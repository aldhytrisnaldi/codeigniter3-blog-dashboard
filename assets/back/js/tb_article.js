$(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
    var t = $("#tb_article").dataTable({
        initComplete: function() {
            var api = this.api();
                $('#mytable_filter input')
                .off('.DT')
                .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                api.search(this.value).draw();
            }
        });
    },
    oLanguage: {
        sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {"url": "Article/json", "type": "POST"},
        columns: [
            {
                "data": "id_article",
                "orderable": true
            },
            {
                "data": "title",
                "render": function(data)
                {
                    return data.substr(data,30)+'...';
                }
            },
            {
                "data": "username",
                "render": function(data)
                {
                    return '<div class="badge bg-navy">'+data+'</div>'
                }
            },
            {
                "data": "category",
                "render": function(data)
                {
                    return '<div class="badge badge-primary"><i class="fas fa-tags"></i> '+data+'</div>'
                }
            },
            {
                "data": "subcategory",
                "render": function(data)
                {
                    return '<div class="badge badge-primary"><i class="fas fa-tags"></i> '+data+'</div>'
                }
            },     
            {
                "data": "status",
                "render": function(data)
                {   
                    if(data == 0){
                        return '<div class="badge badge-warning"><i class="fas fa-edit"></i> Draft</div>'
                    }
                    else{
                        return '<div class="badge badge-success"><i class="fas fa-check"></i> Publish</div>'
                    }
                }
            },
            {
                "data" : "action",
                "orderable": false
            }
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });
});