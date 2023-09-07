@extends('layouts.app')

@section('content')
      <div class="flex flex-col items-center justify-center px-6 py-5 mx-auto md:h-screen lg:py-0">
        <a
          href="#"
          class="flex items-center mt-10 mb-6 text-2xl font-semibold dark:text-gray-900 text-white"
        >
          TCMS
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-2 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Register new account
            </h1>
            <form class="space-y-4 md:space-y-4" action="#">
              <div>
                    <label for="fullname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your FullName</label>
                    <input type="text" name="fullname" id="fullname" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Full Name" required="" />
                </div>
              <div>
                <label
                  for="email"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Email
                </label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="name@company.com"
                  required=""
                />
              </div>
              <div>
                <label
                  for="organization"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Your Organization
                </label>
                <input
                  type="text"
                  name="organization"
                  id="organization"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="Organization"
                  required=""
                />
              </div>
              <div>
                <label
                  for="password"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Password
                </label>
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  required=""
                />
              </div>
              <div>
                <label
                  for="confpassword"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >
                  Confirm Password
                </label>
                <input
                  type="password"
                  name="confpassword"
                  id="confpassword"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  required=""
                />
              </div>
              
              <button
                type="submit"
                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
              >
                Sign up
              </button>
              <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    Have an account already? <a href="/auth/" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign in</a>
                </p> 
            </form>
          </div>
        </div>
      </div>
    {{-- <div class=" flex justify-center">
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
    </div> --}}
   
@endsection