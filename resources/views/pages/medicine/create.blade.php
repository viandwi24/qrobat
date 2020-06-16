@extends('layouts.app', ['title' => 'Create Medicine'])

@section('content')
    <div class="row">
        <div class="col-12">
                <div class="card-box table-responsive">
                    <div class="mb-4">
                        <h4 class="mt-0 header-title" style="display: inline-block;">Create Medicine</h4>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="p-2">
                                <form class="form-horizontal" role="form" method="POST" action="{{ route('medicine.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2  col-form-label" for="simpleinput">Name</label>
                                        <div class="col-sm-10">
                                            <input name="name" value="{{ old('name') }}" type="text" id="name" class="form-control" placeholder="name...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2  col-form-label" for="simpleinput">Stock</label>
                                        <div class="col-sm-10">
                                            <input name="stock" value="{{ old('stock') }}" type="number" id="unit" class="form-control" placeholder="stock...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2  col-form-label" for="simpleinput">Unit</label>
                                        <div class="col-sm-10">
                                            <input name="unit" value="{{ old('unit') }}" type="text" id="unit" class="form-control" placeholder="unit...ex:pill,bottle,box,caplets">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2  col-form-label" for="simpleinput">Price</label>
                                        <div class="col-sm-10">
                                            <input name="price" value="{{ old('price', 1000) }}" type="number" id="unit" class="form-control" placeholder="price...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-2">
                                            <a href="{{ route('medicine.index') }}" class="btn btn-danger">Back</a>
                                            <button class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop