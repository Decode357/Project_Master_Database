@extends('layouts.sidebar')
@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('content')

<!-- ส่งข้อมูลผ่าน data attributes -->
<div id="chart-data" 
    data-dates="{{ json_encode($dates) }}" 
    data-shape-counts="{{ json_encode($shapeCounts) }}"
    data-pattern-counts="{{ json_encode($patternCounts) }}"
    data-backstamp-counts="{{ json_encode($backstampCounts) }}"
    data-glaze-counts="{{ json_encode($glazeCounts) }}"
    style="display: none;">
</div>

<main class="flex-1 bg-gray-50 dark:bg-gray-900">
    <!-- Summary Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-3">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col items-center ">
            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $shapeCount }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wider">Shapes</span>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col items-center ">
            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $patternCount }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wider">Patterns</span>
        </div>        
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col items-center ">
            <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $backstampCount }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wider">Backstamps</span>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col items-center ">
            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $glazeCount }}</span>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase tracking-wider">Glazes</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md md:col-span-2 mb-2 ">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Items Created (Last 30 Days)</h2>
        <div class="w-full" style="height: 220px; position: relative;">
            <canvas id="productChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6">
        <!-- Latest Shapes -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md ">
            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Shape History</h2>
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Shape Code</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestShapes as $shape)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $shape->item_code }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ Str::limit($shape->item_description_eng ?? '-',20) }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $shape->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end text-gray-900 dark:text-gray-100">{{ $shape->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Latest Glazes -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Glaze History</h2>
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Glaze Code</th>
                        <th class="px-4 py-2">Inside Color Code</th>
                        <th class="px-4 py-2">Outside Color Code</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestGlazes as $glaze)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $glaze->glaze_code }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $glaze->glazeInside->glaze_inside_code ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $glaze->glazeOuter->glaze_outer_code ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $glaze->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end text-gray-900 dark:text-gray-100">{{ $glaze->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>        
        <!-- Latest Patterns -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Pattern History</h2>
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Pattern Code</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPatterns as $pattern)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pattern->pattern_code }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pattern->pattern_name }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $pattern->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end text-gray-900 dark:text-gray-100">{{ $pattern->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Latest Backstamps -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Backstamp History</h2>
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-400">
                <thead class="text-xs text-gray-500 dark:text-gray-400 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2">Backstamp Code</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestBackstamps as $backstamp)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $backstamp->backstamp_code }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $backstamp->name }}</td>
                            <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $backstamp->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end text-gray-900 dark:text-gray-100">{{ $backstamp->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400 dark:text-gray-500">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Chart.js และ Chart Manager -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/chart-manager.js') }}"></script>
@endsection

