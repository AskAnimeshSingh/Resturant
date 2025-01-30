@extends('admin.layout.layouts')
@section('extra_css')
<style>
    </style>
@endsection

@section('content')
<section class= "section">
    <div class= "section body">
        <div class= "row">
        <div class="col-12">
            <div class="card">
                <div class="card-header float-right">
                    <h4>Booked Table Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="detail">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Booked Table</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                    <th>Area</th>
                                    <th>Cabin Number</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ( $detail as $val )
                                <td>{{$val->book_table_id,  }}</td>
                                <td>{{$val->start_date,     }}</td>
                                <td>{{$val->end_date,       }}</td>
                                <td>{{$val->end_time,       }}</td>
                                <td>{{$val->start_time,     }}</td>
                                <td>{{$val->area,           }}</td>
                                <td>{{$val->table_num,      }}</td>
                                <td>{{$val->first_name,     }}</td>
                                <td>{{$val->last_name,      }}</td>
                                
                                @endforeach --}}
                                
                            </tbody>
                        </table>
                        {{-- {{ $detail->links() }} --}}
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
</section>
@section('extra_js')
<script>
    var tables = $('#detail').DataTable({
    "processing": true,
    pageLength: 10,
    "serverSide": true,
    "ajax": {
      url: "{{route('admin.table.get_booked_table_ajax')}}",
      dataFilter: function(data) {
        var json = jQuery.parseJSON(data);
        json.recordsTotal = json.recordsTotal;
        json.recordsFiltered = json.recordsFiltered;
        json.data = json.data;
        return JSON.stringify(json); // return JSON string
      }
    },

    'order': [
      [1, 'desc']
    ],
    'columnDefs': [{
               "targets": 0,
               "name": "book_table_id",
               'searchable': false,
               'orderable': false
            },
            {
               "targets": 1,
               "name": "start_date",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 2,
               "name": "end_date",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 3,
               "name": "start_time",
               'searchable': true,
               'orderable': true
            },
            {
               "targets": 4,
               "name": "end_time",
               'searchable': true,
               'orderable': true
            },

            {
               "targets": 5,
               "name": "area",
               'searchable': true,
               'orderable': true
            },

            {
               "targets": 6,
               "name": "table_num",
               'searchable': true,
               'orderable': true
            },

            {
               "targets": 7,
               "name": "first_name",
               'searchable': true,
               'orderable': true
            },

            {
               "targets": 8,
               "name": "last_name",
               'searchable': true,
               'orderable': true
            },
    ],
  });
    </script>
@endsection
@endsection