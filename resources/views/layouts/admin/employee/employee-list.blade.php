<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Employee List</h4>
            <div class="row">
                <div class="col-sm-4">
                    @if($roles)
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                                <span class="input-group-text">Filter by</span>
                            </div>
                            <select class="form-control text-white" id="order" name="order" onchange="return filterEmp(this)">
                                <option value="0">All</option>
                                @foreach($roles as $role)
                                <option value="{{$role->role_id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                                <span class="input-group-text">Search</span>
                            </div>
                            <input type="text" class="form-control " placeholder="Search by name or email or phone or ID or post or department" aria-label="Username" aria-describedby="basic-addon1" onkeyup="return searchEmpList(this)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <br>
                <div class="table-responsive" id="emp-table">
                    @include('layouts.admin.employee._emp_list')
                    @if(@$employees->links())
                        {!! @$employees->links() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
