<!doctype html>
<html lang="en">

<head>
    <title>Laravel 9 Fullcalandar Jquery Ajax Create and Delete Event </title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    @include('partials._navbar')
    {{-- VIEW OUTPUT --}}
    <main>
        @yield('content')
    </main>


    <footer
        class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>

        <a href="/listings/create" class="absolute top-1/3 right-10 bg-black text-white py-2 px-5">Post Job</a>
    </footer>
    <x-flash_message />

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script>
    $(document).ready(function() {
        //var user_id = 2;

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            navLinks: true,
            editable: true,
            events: "/", //this is root of the project where every one can see the events
            displayEventTime: false,
            eventRender: function(event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    var start = moment(start, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var end = moment(end, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    $.ajax({
                        url: "{{ URL::to('createevent') }}",
                        data: 'title=' + title + '&start=' + start + '&end=' +
                            end +
                            '&_token=' + "{{ csrf_token() }}",
                        type: "post",
                        success: function(data) {
                            console.log(data);
                            alert("Added Successfully");
                            $('#calendar').fullCalendar('refetchEvents');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                            if (errorThrown == 'Unauthorized') {
                                alert(
                                    'You need to login to create an event'
                                );
                                window.location.replace(
                                    "{{ URL::to('login') }}");
                            } else {
                                alert(errorThrown);
                            }
                        }

                    });

                }
            },
            eventClick: function(event) {
                var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: "{{ URL::to('deleteevent') }}",
                        data: "&id=" + event.id + '&_token=' + "{{ csrf_token() }}",
                        success: function(response) {
                            if (parseInt(response) > 0) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                alert("Deleted Successfully");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                            if (errorThrown == 'Unauthorized') {
                                alert('You need to login to delete an event');
                                window.location.replace("{{ URL::to('login') }}");
                            } else {
                                alert(errorThrown);
                            }
                        }
                    });
                }
            }
        });
    });
</script>

</html>
