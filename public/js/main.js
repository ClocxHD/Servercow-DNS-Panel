$(() => {
    let lang = $("html").attr("lang");
    let langName = "english";

    if (lang === "de") {
        langName = "german";
    }

    let hash = document.location.hash;
    let prefix = "#domain-";
    let panelPrefix = "#domain-panel-";
    let hashID = hash.replace(prefix, "");

    if (hash) {
        $("#select_domain").val(hashID);
        $("[id^=record-hash]").val(prefix + hashID);

        $(".domain-panel").each(function () {
            $(this).removeClass("is-active");
            $(this).addClass("is-hidden");
        });

        $(panelPrefix + hashID).addClass("is-active");
        $(panelPrefix + hashID).removeClass("is-hidden");

        $("#form-add-record #domain").val(hashID);
    }

    $("#mainBurger").on("click", function () {
        let burgerIcon = $(this);
        let menu = $("#mainNavbar");

        burgerIcon.toggleClass("is-active");
        menu.toggleClass("is-active");
    });

    $(".modal-closer, .modal-background").on("click", function () {
        $(this).closest(".modal").removeClass("is-active");
    });

    $(".record-table").DataTable({
        "order": [[0, "asc"]],
        "pageLength": 20,
        "lengthMenu": [[10, 20, 25, 50, 100], [10, 20, 25, 50, 100]],
        language: {
            url: '/js/libs/jqDataTablesTranslations/dataTables.' + langName + '.json'
        }
    })

    $(".delete-btn").on("click", function() {
        let form = $(this).parent("form");
        let name = $(this).data("name");
        let deleteType = $(this).data("delete");

        //Translations
        let deleteTitle = "";

        if (deleteType === "domain") {
            deleteTitle = swalDeleteDomainTitle;
            deleteText1 = swalDeleteDomainText1;
            deleteText2 = swalDeleteDomainText2;
            deleteYes = swalDeleteDomainYes;
        } else {
            deleteTitle = swalDeleteRecordTitle;
            deleteText1 = swalDeleteRecordText1;
            deleteText2 = swalDeleteRecordText2;
            deleteYes = swalDeleteRecordYes;
        }

        swal({
            title: deleteTitle + "?",
            text: deleteText1 + "<b>" + name + "</b>" + deleteText2 + "?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d433',
            cancelButtonColor: '#3085d6',
            confirmButtonText: deleteYes + "!",
            cancelButtonText: cancel
        }).then((isConfirm) => {
            if (isConfirm) {
                form.submit();
            }
        });
    });

    $(".edit-btn").on("click", function () {
        let editType = $(this).data("edit");
        let url = $(this).data("url");
        let modal = $("#recordEditModal");

        $.get(url, function (data) {
            console.log(data);

            modal.find("#edit_record_id").val(data.id);
            modal.find("#edit_name").val(data.name + "." + data.domain);
            modal.find("#edit_type").val(data.type);
            modal.find("#edit_content").val(data.content);
            modal.find("#edit_ttl").val(data.ttl);

            modal.addClass("is-active animate__animated animate__fadeIn animate__faster");
        });
    });

    $("#select_domain").on("change", function () {
        let domainId = $(this).val();
        window.location.hash = prefix + domainId;

        $(".domain-panel").each(function () {
            if ($(this).hasClass("domain-panel-" + domainId)) {
                $(this).removeClass("is-hidden");
                $(this).addClass("is-active");
            } else {
                $(this).removeClass("is-active");
                $(this).addClass("is-hidden");
            }
        });
    });
})
