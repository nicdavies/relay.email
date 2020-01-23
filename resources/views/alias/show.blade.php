@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            @include('partials.alias_header')
            @include('partials.alias_nav')
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header border-bottom">
            <h3 class="block-title">Latest Activity</h3>
        </div>

        <div class="block-content block-content-full block-content-sm">
            <table class="table table-striped table-borderless table-vcenter">
                <tbody>
                @foreach($activity as $item)
                    <tr>
                        <td class="text-center" style="width: 50px;">
                            <div class="font-size-sm font-w700 text-uppercase">{{ $item->created_at->englishMonth }}</div>
                            {{ $item->created_at->day }}
                        </td>
                        <td class="text-center text-warning" style="width: 40px;">
                            <i class="fa fa-arrow-right"></i>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div class="font-w600">{{ $item->description }}</div>
                        </td>
                        <td class="text-right">
                            <div class="font-w600">{{ $item->created_at }}</div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
