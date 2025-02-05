@extends('layouts.app')

@section('content')

<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            padding: 20px;
            background-color: #007bff;
            color: white;
        }
        main {
            padding: 20px;
        }
        footer {
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <header>
        <h1>Welcome to My Laravel App</h1>
    </header>
    <main>
        <p>This is a simple home page.</p>
    </main>

@endsection


