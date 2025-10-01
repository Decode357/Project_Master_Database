@extends('layouts.sidebar')
@section('title', 'Shape')
@section('header', 'Shape')
@section('content')
<main x-data="shapePage()" x-init="initSelect2()">
    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-3">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input type="text" placeholder="Search by ITEM CODE or etc.." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                </div>
            </div>
            <div class="md:col-span-2 flex justify-end items-center gap-4">
                <button @click="openCreateModal()" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                    <span class="material-symbols-outlined">add</span>
                    <span>Add Shape</span>
                </button>
            </div>
        </div>
    </div>

    <div class="rounded-xl p-3 shadow-md bg-white">
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ITEM CODE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description TH</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description EN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                TYPE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                STATUS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                PROCESS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                UPDATED BY</th>
                            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ACTION</th>
                        </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($shapes as $shape)
                        @php
                            $status = $shape->status->status ?? 'Unknown';
                            $type = $shape->shapeType->name ?? 'Unknown';
                            $process = $shape->process->process_name ?? 'Unknown';
                            $updatedBy = $shape->updater->name ?? 'Unknown';
                            $statusColor = match ($status) {
                                'Approved' => 'bg-green-100 text-green-800',
                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                'Rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $shape->item_code }}</td>
                            <td class="px-6 py-4">{{ $shape->item_description_thai }}</td>
                            <td class="px-6 py-4">{{ $shape->item_description_eng }}</td>
                            <td class="px-6 py-4">{{ $type }}</td>
                            <td class="px-6 py-4">
                                <span class="{{ $statusColor }} px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $process }}</td>
                            <td class="px-6 py-4">{{ $updatedBy }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button @click="ShapeDetailModal = true" class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md transition-all duration-200 hoverScale">
                                        <span class="material-symbols-outlined text-white">feature_search</span>
                                        <span>Detail</span>
                                    </button>

                                    <button @click="openEditModal({{ $shape->toJson() }})" class="text-blue-600 hoverScale hover:text-blue-700">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <button @click="DeleteShapeModal = true; shapeIdToDelete = {{ $shape->id }}; itemCodeToDelete = '{{ $shape->item_code }}'" class="text-red-500 hoverScale hover:text-red-700">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-end">
                {{ $shapes->links('vendor.pagination.tailwind-custom') }}
            </div>
        </div>
    </div>

    @include('components.Edit-modals.edit-shape')
    @include('components.ShapeDetail-modal')
    @include('components.CreateShape-modal')
    @include('components.Delete-modal')
</main>

<script>
function shapePage() {
    return {
        ShapeDetailModal: false,
        CreateShapeModal: @json($errors->any()),
        EditShapeModal: false,
        DeleteShapeModal: false,
        shapeIdToDelete: null,
        shapeToEdit: {},
        itemCodeToDelete: '',

        openEditModal(shape) {
            this.shapeToEdit = JSON.parse(JSON.stringify(shape)); // clone กัน reactive bug
            this.EditShapeModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditShapeModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม shapeToEdit
                    if (shape[name] !== undefined && shape[name] !== null) {
                        $this.val(shape[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        shape[name] = $(this).val();
                    });
                });
            });
        },

        openCreateModal() {
            this.CreateShapeModal = true;

            this.$nextTick(() => {
                let $modal = $('#CreateShapeModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);

                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    $this.on('change', function () {
                        // ถ้าอยาก sync Alpine ก็ทำได้ แต่ create ใช้ old() อยู่แล้ว
                    });
                });
            });
        }
    }
}
</script>
@endsection
