@extends('layout')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Date From</th>
                <th scope="col">Date To</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>

            @unless($events->isEmpty())
                @foreach ($events as $event)
                    <tr>
                        <th scope="row">{{ $event->id }}</th>
                        <td>
                            <a href="show.html">
                                {{ $event->title }}
                            </a>
                        </td>
                        <td>
                            <a href="show.html">
                                {{ $event->start }}
                            </a>
                        </td>
                        <td>
                            <a href="show.html">
                                {{ $event->end }}
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-info" href="/events/{{ $event->id }}/edit"><i
                                    class="fa-solid fa-pen-to-square"></i>
                                Edit</a>
                        </td>
                        <td>

                            <form method="POST" action="/deleteevent/{{ $event->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Deleteee
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-3 text-lg">
                        <p class="text-center"> No Listing</p>
                    </td>
                </tr>
            @endunless




        </tbody>
    </table>
@endsection
