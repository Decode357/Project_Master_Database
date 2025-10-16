@extends('layouts.sidebar')
@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('content')
<!-- Chart.js CDN -->
<script src="{{ asset('js/pages/dashboard-page.js') }}"></script>
<!-- ส่งข้อมูลผ่าน data attributes -->
<div id="chart-data" 
    data-dates="{{ json_encode($dates) }}" 
    data-product-counts="{{ json_encode($productCounts) }}"
    data-shape-counts="{{ json_encode($shapeCounts) }}"
    data-pattern-counts="{{ json_encode($patternCounts) }}"
    data-backstamp-counts="{{ json_encode($backstampCounts) }}"
    data-glaze-counts="{{ json_encode($glazeCounts) }}"
    data-user-counts="{{ json_encode($userCounts) }}"
    style="display: none;">
</div>

<main class="flex-1 bg-gray-50" x-data="{ CreateEffectModal: false, DeleteModal: false }">
    <!-- Summary Bar -->
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-green-500">{{ $productCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Products</span>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-blue-600">{{ $shapeCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Shapes</span>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-green-600">{{ $patternCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Patterns</span>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-yellow-600">{{ $backstampCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Backstamps</span>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-purple-600">{{ $glazeCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Glazes</span>
        </div>
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center">
            <span class="text-2xl font-bold text-black">{{ $userCount }}</span>
            <span class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Users</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md md:col-span-2 mb-6">
        <h2 class="text-lg font-semibold mb-4">Items Created (Last 30 Days)</h2>
        <div class="w-full" style="height: 220px; position: relative;">
            <canvas id="productChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Latest Products -->
        <div class="bg-white p-6 rounded-lg shadow-md md:col-span-2 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">Latest Products</h2>
            <table class="w-full text-sm text-left text-gray-600 ">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Product SKU</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2 hidden md:table-cell">Shape</th>
                        <th class="px-4 py-2 hidden md:table-cell">Pattern</th>
                        <th class="px-4 py-2 hidden md:table-cell">Backstamp</th>
                        <th class="px-4 py-2 hidden md:table-cell">Glaze</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestProducts as $product)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $product->product_sku }}</td>
                            <td class="px-4 py-2">{{ Str::limit($product->product_name ?? '-', 20) }}</td>
                            <td class="px-4 py-2 hidden md:table-cell">{{ $product->shape->item_code ?? '-' }}</td>
                            <td class="px-4 py-2 hidden md:table-cell">{{ $product->pattern->pattern_code ?? '-' }}</td>
                            <td class="px-4 py-2 hidden md:table-cell">{{ $product->backstamp->backstamp_code ?? '-' }}</td>
                            <td class="px-4 py-2 hidden md:table-cell">{{ $product->glaze->glaze_code ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $product->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end">{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-2 text-center text-gray-400">No data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Latest Shapes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Latest Shapes</h2>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Item Code</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestShapes as $shape)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $shape->item_code }}</td>
                            <td class="px-4 py-2">{{ Str::limit($shape->item_description_eng ?? '-',20) }}</td>
                            <td class="px-4 py-2">{{ $shape->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end">{{ $shape->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Latest Patterns -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Latest Patterns</h2>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Pattern Code</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestPatterns as $pattern)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $pattern->pattern_code }}</td>
                            <td class="px-4 py-2">{{ $pattern->pattern_name }}</td>
                            <td class="px-4 py-2">{{ $pattern->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end">{{ $pattern->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Latest Backstamps -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Latest Backstamps</h2>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Backstamp Code</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestBackstamps as $backstamp)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $backstamp->backstamp_code }}</td>
                            <td class="px-4 py-2">{{ $backstamp->name }}</td>
                            <td class="px-4 py-2">{{ $backstamp->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end">{{ $backstamp->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Latest Glazes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mb-4">Latest Glazes</h2>
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Glaze Code</th>
                        <th class="px-4 py-2">Glaze Inside</th>
                        <th class="px-4 py-2">Glaze Outside</th>
                        <th class="px-4 py-2">Updated By</th>
                        <th class="px-4 py-2 text-end">Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestGlazes as $glaze)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $glaze->glaze_code }}</td>
                            <td class="px-4 py-2">{{ $glaze->glazeInside->glaze_inside_code ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $glaze->glazeOuter->glaze_outer_code ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $glaze->updater->name ?? 'System' }}</td>
                            <td class="px-4 py-2 text-end">{{ $glaze->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-2 text-center text-gray-400">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection

