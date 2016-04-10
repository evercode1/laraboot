<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js">
</script>
<script>
    $(document).ready( function () {

        $('#user_table').DataTable({
            select: false,
            "ajax": {
                "url": "/api/user",
                "type": "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            },
            "columns": [
                { "data": "id" },
                { "data": "name",
                    "render": function(data,type,row,meta) {
                        return '<a href="/user/'+row.id+'">'+data+'</a>';
                    }
                },
                { "data": "email" },

                { "data": "is_subscribed",
                    "render": function ( data, type, full, meta ) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                { "data": "is_admin",
                    "render": function ( data, type, full, meta ) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                { "data": "status_id",
                    "render": function ( data, type, full, meta ) {
                        return data == 10 ? 'Active' : 'Inactive';
                    }


                },
                { "data": "created_at",
                    "render": function ( data, type, full, meta ) {

                        // instantiate a moment object and hand it the string date
                        var d = moment(data);

                        var month = d.month() +1 < 10 ? "0" + (d.month() +1) : d.month() +1;
                        var day = d.date()  < 10 ? "0" + (d.date()): d.date();
                        return month + "/" + day + "/" + d.year();
                    }
                },

                {"defaultContent": "null", "render": function(data,type,row,meta) {
                    return '<a href="/user/'+row.id+'/edit">'+ '<button>Edit</button>' + '</a>';
                }

                }
            ]

        });

    } );
</script>