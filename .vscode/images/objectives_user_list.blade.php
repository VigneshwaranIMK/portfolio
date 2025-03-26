@extends('admin/inc/layout')
@section('content')
@section('title', 'Objective')

@php
    if (empty($obj)) {
        $obj = 0;
    }
    if (empty($hr)) {
        $hr = '';
    }

    if (empty($count)) {
        $count = '';
    }
    if (empty($mgr)) {
        $mgr = '';
    }
@endphp

<style>

    .accordion {
        background-color: rgb(236, 31, 31);
        border: none;
        cursor: pointer;
        padding: 10px 20px;
        text-align: left;
        font-size: medium;
        font-weight: bold;
        color: #14c0de;
        text-decoration: underline;
        width: 100%;
        outline: none;
        transition: background-color 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: 'Roboto', sans-serif;
    }

    .accordion:hover {
        background-color: #e0e0e0;
    }

    .accordion i {
        margin-left: auto;
        font-size: 15px;
        transition: transform 0.3s ease;
    }

    .accordion.active i {
        transform: rotate(180deg);
    }
     .show-by {
        width: fit-content;
    }
    .SortDis:before,.SortDis:after{
        content: "" !important;
        cursor: none !important;
    }
</style>

<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>-->

<!-- form start -->
<div class="col-12 grid-margin stretch-card">
    @include('auth.error_msg')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="@if(count($datas) > 0) table-responsive @endif">
                    <table class="datatable table table-striped text-center" id="tableToExport">
                        @if (count($datas) <= 0)
                            <a href="{{ url('performance_objectives') }}" class="hover-link text-info"><i
                                    class="fa fa-plus"></i>
                                Add New Objectives</a>
                        @else
                    </table>
                    <table class="datatable table table-striped text-center" id="tableToExport">
                        @if (!Route::is('obj_userlist_archive'))
                            <thead>
                                <tr>
                                    <td>S.No</td>
                                    <td>Employee ID</td>
                                    <td>Name</td>
                                    <td>Period</td>
                                    <td style="max-width: 200px;">Status</td>
                                    <td class="SortDis">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $index => $data)
                                    <tr>
                                        <td class="text-left">{{ $index + 1 }}</td>
                                        <td>{{ $data->employee_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td> {{ $data->period }} </td>
                                        <td>
                                            @if ($data->status === 'revise')
                                                <span class="text-danger">Your objectives were rejected. Kindly update
                                                    your
                                                    objectives</span>
                                            @elseif ($data->status === 'self-assessment')
                                                <span style="color: orange">Update Your Self Assessment & Self
                                                    Rating</span>
                                            @elseif ($data->status === 'Draft')
                                                <span style="color: orange">Draft</span>
                                            @elseif ($data->status === 'Add_Objectives')
                                                <span style="color: orange">Update Your Objectives for the Period of
                                                    {{ $data->period }} </span>
                                            @elseif ($data->status === 'request')
                                                <span style="color: orange"> Submitted for Approval</span>
                                            @elseif ($data->status === 'hr_self')
                                                <span style="color: orange"> Objectives Approved</span>
                                            @elseif ($data->status === 'Approved')
                                                <span style="color: grey"> Appraisal Closed</span>
                                            @elseif ($data->status === 'edit_request')
                                                <span style="color: rgb(246, 15, 15)"> Edit Request Pending With
                                                    Manager</span>
                                            @elseif ($data->status === 'edit')
                                                <span style="color: rgb(15, 107, 246)"> Edit Request Approved you can
                                                    Edit
                                                    Now</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Route::is('obj_userlist_archive'))
                                                <a target="_blank"
                                                    href="{{ url('objectives_download/' . Crypt::encryptString($data->id)) }}"><i
                                                        class="fa fa-file-pdf-o" aria-hidden="true" title="View PDF"
                                                        style="color:rgb(193 1 1);"></i> </a>
                                            @else
                                                @if ($data->status === 'Approved' || $data->status === 'hr_self' || $data->status === 'edit_request')
                                                    <a target="_blank"
                                                        href="{{ url('objectives_download/' . Crypt::encryptString($data->id)) }}"><i
                                                            class="fa fa-file-pdf-o" aria-hidden="true" title="View PDF"
                                                            style="color:rgb(193 1 1);"></i> </a>&nbsp;&nbsp;
                                                    <a type="button" id="modalopen" class="text-danger"
                                                        data-toggle="modal" data-target="#addobjModal"><i
                                                            class="fa fa-pencil text-danger" aria-hidden="true"></i>
                                                        Edit</a>
                                                @elseif (
                                                    $data->status === 'Add_Objectives' ||
                                                        $data->status === 'revise' ||
                                                        $data->status === 'self-assessment' ||
                                                        $data->status === 'edit' ||
                                                        'Draft')
                                                    <a href="{{ url('objectives_edit/' . Crypt::encryptString($data->id)) }}"
                                                        title="Edit"><i class="fa fa-pencil-square-o"
                                                            aria-hidden="true"></i></a>
                                                @else
                                                    <a target="_blank"
                                                        href="{{ url('objectives_download/' . Crypt::encryptString($data->id)) }}"><i
                                                            class="fa fa-file-pdf-o" aria-hidden="true" title="View PDF"
                                                            style="color:rgb(193 1 1);"></i> </a>

                                                    <a href="#" id="modalopen" class="text-danger"
                                                        data-toggle="modal" data-target="#addobjModal"><i
                                                            class="fa fa-pencil text-danger" aria-hidden="true"></i>
                                                        Edit</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                    @endif
                    @if (Route::is('obj_userlist_archive'))
                        @foreach ($datasFN as $key => $dataFN)
                            @if ($dataFN != $financialYearLabel)
                                <button id="accordion_view{{ $key }}"
                                    class="accordion text-info text-underline"
                                    style="background-color:rgb(241, 241, 241); font-size: larger;">
                                    {{ $dataFN }}
                                    <i class="fa fa-angle-down" align="right" aria-hidden="true"></i></button>
                                <div class="panel" style="display: none";>
                                    <div class="table-responsive">
                                        <table class="datatable table table-striped text-center" id="tableToExport">
                                            <thead>
                                                <tr>
                                                    <td>Employee Id</td>
                                                    <td>Name</td>
                                                    <td>Period</td>
                                                    <td>Status</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $dataFound = false; @endphp
                                                @foreach ($datas as $indexs => $data)
                                                    @if ($dataFN == $data->period)
                                                        @php $dataFound = true; @endphp
                                                        <tr>
                                                            <td> {{ $data->employee_id }} </td>
                                                            <td> {{ $data->name }} </td>
                                                            <td> {{ $data->period }}</td>

                                                            <td>
                                                                @if ($data->status === 'revise')
                                                                    <span class="text-danger">Your objectives were
                                                                        rejected.
                                                                        Kindly update
                                                                        your
                                                                        objectives</span>
                                                                @elseif ($data->status === 'self-assessment')
                                                                    <span style="color: orange">Update Your Self
                                                                        Assessment &
                                                                        Self
                                                                        Rating</span>
                                                                @elseif ($data->status === 'Draft')
                                                                    <span style="color: orange">Draft</span>
                                                                @elseif ($data->status === 'Add_Objectives')
                                                                    <span style="color: orange">Update Your Objectives
                                                                        for the
                                                                        Period of
                                                                        {{ $data->period }} </span>
                                                                @elseif ($data->status === 'request')
                                                                    <span style="color: orange"> Submitted for
                                                                        Approval</span>
                                                                @elseif ($data->status === 'hr_self')
                                                                    <span style="color: orange"> Objectives
                                                                        Approved</span>
                                                                @elseif ($data->status === 'Approved')
                                                                    <span style="color: grey"> Appraisal Closed</span>
                                                                @elseif ($data->status === 'edit_request')
                                                                    <span style="color: rgb(246, 15, 15)"> Edit Request
                                                                        Pending
                                                                        With
                                                                        Manager</span>
                                                                @elseif ($data->status === 'edit')
                                                                    <span style="color: rgb(15, 107, 246)"> Edit Request
                                                                        Approved you can
                                                                        Edit
                                                                        Now</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($data->status === 'Approved' || $data->status === 'hr_self')
                                                                    <a target="_blank"
                                                                        href="{{ url('objectives_download/' . Crypt::encryptString($data->id)) }}"><i
                                                                            class="fa fa-file-pdf-o" aria-hidden="true"
                                                                            title="View PDF"
                                                                            style="color:rgb(193 1 1);"></i>
                                                                    </a>
                                                                @elseif ($data->status === 'Add_Objectives' || $data->status === 'revise' || $data->status === 'self-assessment')
                                                                    <a href="{{ url('objectives_edit/' . Crypt::encryptString($data->id)) }}"
                                                                        title="Edit"><i class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                @if (!$dataFound)
                                                    <tr>
                                                        <td colspan="4">No Data Available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Popup Form -->
    <div class="modal fade" id="addobjModal" data-backdrop="true" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Performance Objectives Edit Request</h4>
                    <button type="button" class="btn-close" onclick="closedobjModals()" aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off" action="{{ url('objectives_open_request') }}" method="post">
                        @csrf
                        @php
                            $user = Auth::user()->employee_id;
                        @endphp
                        <div class="form-group">
                            <input type="text" name="user_id" value="{{ $user }}" hidden>

                            <label for="request_reason">Request Reason <span class="text-danger">*</span></label>
                            <textarea name="request_reason" maxlength="490" class="form-control" id="request_reason" rows="3" required></textarea>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            <button type="button" onclick="closedobjModals()"
                                class="btn btn-dark btn-sm">Close</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    @push('body-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($datasFN as $key => $dataFN)
                    @if ($dataFN != $financialYearLabel)
                        var named = 'accordion_view{{ $key }}';
                        console.log(named);
                        var acc = document.getElementById(named);

                        if (acc) {
                            acc.addEventListener("click", function() {
                                this.classList.toggle("active");

                                var panel = this.nextElementSibling;

                                if (panel.style.display === "block") {
                                    panel.style.display = "none";
                                } else {
                                    panel.style.display = "block";
                                }
                            });
                        }
                    @endif
                @endforeach

                // function closedobjModals() {
                //     let modal = document.querySelector('.modal.show'); // Select the active modal
                //     if (modal) { // Ensure a modal is actually open
                //         let modalInstance = bootstrap.Modal.getInstance(modal);
                //         if (modalInstance) {
                //             modalInstance.hide(); // Manually close the modal
                //         }
                //     }
                // }
            });
        </script>
        <script>
          function closedobjModals() {
    let modal = document.querySelector('.modal.show'); // Select the active modal
    if (modal) {
        modal.classList.remove('show'); // Remove Bootstrap's "show" class
        modal.style.display = 'none'; // Hide the modal
        modal.setAttribute("aria-hidden", "true"); // Accessibility improvement

        // Remove Bootstrap's modal-open class from body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = ''; // Allow scrolling again

        // Remove Bootstrap's backdrop manually
        let backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove()); // Remove all backdrops
    }
}


        </script>
    @endpush
</div>
@stop
