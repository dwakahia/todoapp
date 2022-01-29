@extends('layouts.app')

@section('content')
    <main class="sm:container sm:mx-auto sm:mt-10">
        <div class="w-full sm:px-6">

            @if (session('success'))
                <div
                    class="text-sm border border-t-8 rounded text-blue-700 border-blue-600 bg-blue-100 px-3 py-4 mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{session('task') ? 'Update Task' : 'Add Task'}}
                </header>

                <div class="w-full px-6 py-2">
                    <form
                        action="{{session('task') ? route('update-task',['task' => session('task.id')]): route('add-task') }}"
                        class="my-3" method="post">
                        @csrf
                        <div class="flex flex-wrap my-3">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                                {{ __('Name') }}:
                            </label>

                            <input id="name" type="text"
                                   class="form-input w-full @error('name') border-red-500 @enderror"
                                   @if(session('task')) value="{{session('task.name')}}" @endif name="name"
                                   required autocomplete="email" autofocus>

                            @error('name')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap my-3">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                                {{ __('Description') }}:
                            </label>

                            <textarea class="form-input w-full @error('description') border-red-500 @enderror"
                                      name="description" id="description" cols="30" rows="3" required>
                                {{session('task') ? session('task.description') : ''}}
                            </textarea>


                            @error('description')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                {{session('task')  ?  'Update Task' :  'Add Task' }}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            <form action="{{route('search-task')}}" id="search-form" method="Get">
                <div class="flex flex-wrap items-stretch mx-auto  w-full md:w-1/2 mt-5 relative">
                    <input type="text" name="searchtxt"
                           class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-r-none px-3 relative"
                           placeholder="Search Task">
                    <div class="flex -mr-px">
                        <a onclick="event.preventDefault();document.getElementById('search-form').submit();"
                           class="flex items-center leading-normal bg-grey-lighter rounded rounded-l-none border border-l-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm cursor-pointer">Search</a>
                    </div>
                </div>
            </form>

            <div class="container my-12 mx-auto px-4 md:px-12">
                <div class="flex flex-wrap -mx-1 lg:-mx-4">

                    @forelse($tasks as $task)
                        <div class="my-1 p-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">

                            <article class="overflow-hidden rounded-lg shadow-lg flex flex-col h-full">
                                <header
                                    class="flex items-center justify-between leading-tight p-2 md:p-4">

                                    <form id="toggle-check-form{{$task->id}}"
                                          action="{{ route('check-toggle-task',['task' => $task->id]) }}"
                                          method="POST">
                                        @csrf
                                        <input type="checkbox" class="form-checkbox" name="status"
                                               {{$task->status == 1 ? 'Checked' : ''}}  onchange="event.preventDefault();document.getElementById('toggle-check-form{{$task->id}}').submit();">
                                    </form>
                                    <h1 class="text-lg">
                                        <a class="no-underline hover:underline text-black" href="#">
                                            {{ucwords($task->name)}}
                                        </a>
                                    </h1>

                                </header>

                                <div class="p-3 flex-grow">
                                    {{$task->description}}
                                </div>

                                <footer
                                    class="flex items-center justify-between leading-none p-2 md:p-4">
                                    <a class="bg-blue-500 p-3 rounded-md text-white font-medium mr-2"
                                       href="{{route('delete-task',['task'=>$task->id])}}">
                                        Delete
                                    </a>
                                    <a class="bg-red-700 p-3 rounded-md text-white font-medium"
                                       href="{{route('edit-task',['task'=>$task->id])}}">Edit
                                    </a>
                                </footer>

                            </article>

                        </div>
                    @empty

                        <p>No tasks</p>
                    @endforelse

                </div>
            </div>

            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
                <div class="row">
                    <div class="col-md-12 p-4 box-border">
                        {{ $tasks->links('pagination::tailwind') }}
                    </div>
                </div>
            </section>

        </div>
    </main>
@endsection
