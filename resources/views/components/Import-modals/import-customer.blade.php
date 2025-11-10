<!-- Customer Import Modal -->
<div id="customerImportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 w-11/12 max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-3 border-b dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                <i class="fas fa-file-import mr-2"></i>{{ __('content.customer_data_import') }}
            </h3>
            <button onclick="closeCustomerModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="mt-4">
            <!-- Alert Messages -->
            @if(session('success')&& session('customer_import'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error')&& session('customer_import'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            @if(session('import_errors') && is_array(session('import_errors'))&& session('customer_import'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md max-h-60 overflow-y-auto">
                    <h4 class="font-bold mb-2"><i class="fas fa-list mr-2"></i>{{ __('content.please_correct_errors') }}</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Step 1: Download Template -->
            <div class="mb-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">
                    <i class="fas fa-step-forward mr-2"></i>{{ __('content.step1text') }}
                </h4>
                <p class="text-gray-600 dark:text-gray-400 mb-3 text-sm">
                    {{ __('content.step1detail') }}
                </p>
                <div class="flex gap-3">
                    <a href="{{ route('customers.template') }}"
                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition
                        dark:bg-blue-500 dark:hover:bg-blue-600 hoverScale">
                        <i class="fas fa-download"></i> {{ __('content.download_template') }}
                    </a>
                    <a href="{{ route('customers.export') }}"
                        class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition
                        dark:bg-purple-500 dark:hover:bg-purple-600 hoverScale">
                        <i class="fas fa-file-export"></i> {{ __('content.export_all_data') }}
                    </a>
                </div>
            </div>

            <!-- Step 2: Upload File -->
            <div class="mb-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">
                    <i class="fas fa-step-forward mr-2"></i>{{ __('content.step2text') }}
                </h4>
                <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('content.select_file') }} (CSV/Excel)
                        </label>
                        <div class="flex space-y-2 flex-row items-center gap-4">
                            <label class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md cursor-pointer hoverScale hover:bg-blue-700 transition dark:bg-blue-500 dark:hover:bg-blue-600">
                                <i class="fas fa-file-upload"></i> {{ __('content.select_file') }}
                                <input 
                                    type="file" 
                                    name="file" 
                                    accept=".csv,.xlsx,.xls" 
                                    required 
                                    class="hidden" 
                                    onchange="document.getElementById('customerFileName').textContent = this.files.length ? this.files[0].name : 'No file selected';"
                                />
                            </label>
                            <p id="customerFileName" class="text-sm text-gray-600 dark:text-gray-300">{{ __('content.no_select_file') }}</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>{{ __('content.supported_formats') }}
                        </p>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeCustomerModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition
                            dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 hoverScale">
                            <i class="fas fa-times"></i>{{ __('content.cancel') }}
                        </button>
                        <button type="button"
                            onclick="if (this.form.reportValidity()) { 
                                this.disabled = true; 
                                this.innerHTML = '{{ __('content.validating') }}'; 
                                this.form.requestSubmit(); 
                            }"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition
                            dark:bg-green-500 dark:hover:bg-green-600 hoverScale">
                            <i class="fas fa-upload"></i> {{ __('content.upload_import') }}
                        </button>   
                    </div>
                </form>
            </div>

            <!-- Instructions -->
            <div class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg">
                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                    <i class="fas fa-book mr-2"></i>{{ __('content.instructions') }}
                </h4>
                <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1 list-disc list-inside">
                    <li>{{ __('content.instruct_1_template') }}</li>
                    <li>{{ __('content.instruct_2_customer_data') }}</li>
                    <li>{!! __('content.instruct_3_code') !!}</li>
                    <li>{{ __('content.instruct_4_duplicate') }}</li>
                    <li>{!! __('content.instruct_5_valid') !!}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function openCustomerModal() {
    document.getElementById('customerImportModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCustomerModal() {
    document.getElementById('customerImportModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('customerImportModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeCustomerModal();
    }
});

// Auto open modal if there are errors
@if((session('error') || session('import_errors') || session('success')) && session('customer_import'))
    window.addEventListener('DOMContentLoaded', () => {
        openCustomerModal();
    });
@endif
</script>