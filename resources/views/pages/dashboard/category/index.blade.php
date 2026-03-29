<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                    // url yang sedang dibuka sekarang
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'thumbnile_category_url',
                        name: 'thumbnile_category_url'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        ordertable: false,
                        searchable: false,
                        width: '25%'
                    }
                ]

            })

            function toggleModal() {
                document.getElementById('categoryModal').classList.toggle('hidden');
            }

            function editCategory(id) {
                $.get("{{ url('dashboard/category') }}/" + id + "/edit", function(data) {
                    $('#modalTitle').text("Edit Category");
                    $('#categoryId').val(data.id);
                    $('#name').val(data.category_name);
                    toggleModal();
                });
            }

            function saveCategory() {
                var csrf = "{{ csrf_token() }}"
                let formData = new FormData();
                formData.append('_token', csrf);
                formData.append('name', $('#name').val());
                var thumbnailFile = $('#thumbnail')[0].files[0];

                if (thumbnailFile) {
                    formData.append('thumbnail', thumbnailFile);
                }

                var categoryId = $('#categoryId').val();
                var url = categoryId ? "{{ url('dashboard/category') }}/" + categoryId :
                    "{{ route('dashboard.category.store') }}";
                var type = categoryId ? "POST" : "POST";

                if (categoryId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#categoryForm').trigger("reset");
                        toggleModal();
                        datatable.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success
                        });
                    },
                    error: function(response) {
                        let error = response.responseJSON.errors ? response.responseJSON.errors.join(', ') :
                            'Error occurred';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error
                        });
                    }
                });

            }
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <button onclick="toggleModal()"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + create category
                </button>
            </div>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <x-category-modal />
</x-app-layout>
