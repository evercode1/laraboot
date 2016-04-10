<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script>
$(document).ready( function () {
$('#image_table').DataTable({

    "order": [[ 4, "asc" ]],
select: false,
"ajax": {
"url": "/api/marketing-image",
"type": "POST",
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
},

"columns": [
{ "data": "id",
    "render": function(data,type,row,meta) {

        var thumbnailPath = '<?php echo $thumbnailPath ;?>';
        return '<a href="/marketing-image/'+row.id+'">' +
                '<img src="' + thumbnailPath
                +row.image_name+'.'+row.image_extension+'"></a>';
    }
},




{ "data": "image_name",
"render": function(data,type,row,meta) {
    return '<a href="/marketing-image/'+row.id+'">'+ data +'</a>';
}
},


    { "data": "is_active",
        "render": function(data,type,row,meta) {
            return (data == 1) ? 'Yes' : 'No';
        }
    },

{ "data": "is_featured",
    "render": function(data,type,row,meta) {
        return (data == 1) ? 'Yes' : 'No';
    }
},

    { "data": "image_weight"},

{ "data": "image_extension"},



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
return '<a href="/marketing-image/'+row.id+'/edit">'+ '<button>Edit</button>' + '</a>';
}
}

]

});

});

</script>


