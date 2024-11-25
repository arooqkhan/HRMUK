@extends('admin.master.main')

@section('content')

<div class="row">
    <div id="flStackForm" class="col-lg-12 layout-spacing layout-top-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h3>Add Document</h3>
                    </div>
                </div>
            </div>
            <div class="widget-content widget-content-area">
                <form action="{{ route('document.store') }}" method="POST" id="expenseForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden ID Field -->
                    <input type="hidden" name="id" value="{{ isset($id) ? $id : '' }}">

                    <!-- Employee Dropdown -->
                    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'HR' || auth()->user()->role == 'Accountant')
                    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="inputEmployee">Select Employee</label>
            <select class="form-control" id="inputEmployee" name="employee_id" required>
                <option value="" disabled {{ is_null($id) ? 'selected' : '' }}>Select an Employee</option>

                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" 
                        {{-- Check if $id matches or if first_name and last_name match --}}
                        {{ isset($id) && $id == $employee->id ? 'selected' : '' }}
                        {{ isset($first_name, $last_name) && $first_name == $employee->first_name && $last_name == $employee->last_name ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
    @endif

                    <!-- Document Name Input -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputName">Document Name</label>
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="Document Name" value="{{ old('name', isset($title) ? $title : '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Document Upload -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputDocument">Document file:</label>
                                <input type="file" class="form-control" id="inputDocument" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                <div id="documentPreview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit and Back Buttons -->
                    <div class="row">
                        <div class="col-sm-12 mt-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('inputDocument').addEventListener('change', function(event) {
        var documentPreview = document.getElementById('documentPreview');
        documentPreview.innerHTML = ''; // Clear any existing preview

        var files = event.target.files;
        if (files && files[0]) {
            var file = files[0];
            var fileType = file.type;
            var fileName = file.name;
            var fileURL = URL.createObjectURL(file);

            var preview = document.createElement('div');
            preview.innerHTML = `<strong>Selected File:</strong> ${fileName}<br>`;

            // For PDF files, provide a link to view the file
            if (fileType === 'application/pdf') {
                preview.innerHTML += `<a href="${fileURL}" target="_blank" class="btn btn-info">View PDF</a>`;
            } else {
                // For other document types, provide a link to download the file
                preview.innerHTML += `<a href="${fileURL}" download="${fileName}" class="btn btn-info">Download ${fileName}</a>`;
            }

            documentPreview.appendChild(preview);
        }
    });
</script>

@endsection