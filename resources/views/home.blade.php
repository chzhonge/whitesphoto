@extends('layouts.app')

@section('content')
    @if (Auth::guest())
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="{{ asset('img/maxresdefault.jpg')}}" alt="...">
                    <div class="carousel-caption">
                        長琴無燄
                    </div>
                </div>
                <div class="item">
                    <img src="{{ asset('img/maxresdefault.jpg')}}" alt="...">
                    <div class="carousel-caption">
                        長琴無燄
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @else
        <breadcrumb :user-i-d="{{ @Auth::id() }}"></breadcrumb>
        <!--Vue.js 接收PHP的值 -->
    @endif
@endsection


