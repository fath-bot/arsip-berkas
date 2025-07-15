@extends('admin.layouts.apps')

@section('title', 'Dashboard')

@section('content')
<div class="main-content" id="mainContent">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Selamat Datang {{ session('user_name', 'Admin') }} </h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
        