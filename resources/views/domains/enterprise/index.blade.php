@extends('layouts.in')

@section('body')
    <div class="overflow-auto scroll-visible header-sticky">
        <table id="enterprise-list-table"
               class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap">
            <thead>
            <tr>
                <th class="w-1">{{__('enterprise-index.no')}}</th>
                <th class="w-1">{{__('enterprise-index.name')}}</th>
                <th class="w-1">{{__('enterprise-index.email')}}</th>
                <th class="w-1">{{__('enterprise-index.role')}}</th>
                <th class="w-1">{{__('enterprise-index.enterpriseName')}}</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data as $index =>$row)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>dummy name</td>
                    <td>{{$row['email']}}</td>
                    <td>{{$row['roleName']}}</td>
                    <td>{{$row['name']}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@stop
