<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-inline-block">List of Active Department</h4>
            @if(\Illuminate\Support\Facades\Request::url() == url('admin/department-list'))
                <a href="{{url('admin/add-department')}}" class="btn btn-success float-right">Add Department</a>
            @else
            <a href="{{url('/')}}/admin/department-list" class="btn btn-info float-right">View all Department</a>
            @endif
            </p>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                                <span class="input-group-text">Filter</span>
                            </div>
                            <select class="form-control text-white" id="order" name="order" onchange="return filterDep(this)">
                                <option >Order By Name</option>
                                <option value="1">ASC</option>
                                <option value="2">DESC</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                                <span class="input-group-text">Search</span>
                            </div>
                            <input type="text" class="form-control " placeholder="Search by Department name or email or phone" aria-label="Username" aria-describedby="basic-addon1" onkeyup="return searchDep(this)">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive" id="dep-table">
                @include('layouts.admin.department._dep-list')
                @if($departments->links())
                {!! $departments->links() !!}
                @endif
            </div>
        </div>
    </div>
</div>
