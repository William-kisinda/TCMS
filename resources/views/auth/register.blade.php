@extends('layouts.app')

@section('content')
    <div class=" flex justify-center">
        <div class="w-8/12 bg-white rounded-lg p-6">
             <form action="{{route('register')}}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class=" sr-only">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your name" 
                    class=" bg-gray-100 border-2 w-full p-4 rounded-lg @error('name')
                    border-red-500 @enderror" value="{{ old('name')}}">

                    @error('name')
                        <div class=" text-red-500 mt-2 text-sm">
                            {{ $message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="uname" class=" sr-only">Username</label>
                    <input type="text" name="uname" id="uname" placeholder="Your username" 
                    class=" bg-gray-100 border-2 w-full p-4 rounded-lg @error('uname')
                    border-red-500 @enderror" value="{{ old('uname')}}">

                    @error('uname')
                        <div class=" text-red-500 mt-2 text-sm">
                            {{ $message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class=" sr-only">Email</label>
                    <input type="text" name="email" id="email" placeholder="Your email" 
                    class=" bg-gray-100 border-2 w-full p-4 rounded-lg @error('email')
                    border-red-500 @enderror" value="{{ old('email')}}">
                    @error('email')
                        <div class=" text-red-500 mt-2 text-sm">
                            {{ $message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class=" sr-only">Password</label>
                    <input type="password" name="password" id="password" placeholder="Your password" 
                    class=" bg-gray-100 border-2 w-full p-4 rounded-lg @error('password')
                    border-red-500 @enderror">
                    @error('password')
                        <div class=" text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class=" sr-only">Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Retype password" 
                    class=" bg-gray-100 border-2 w-full p-4 rounded-lg @error('password_confirmation')
                    border-red-500 @enderror">
                    @error('password_confirmation')
                        <div class=" text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4 content-center">
                    <button type="submit" class=" bg-blue-600 text-white px-4 py-3 rounded font-medium w-[14rem]">Register</button>
                </div>
             </form>
        </div> 
    </div>
   
@endsection