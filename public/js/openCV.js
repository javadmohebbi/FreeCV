$(document).ready(function() {






    var btnEditBio = $("#btnEditBio");
    var btnEditBioImage = $(".btnEditBioImage");
    var fileUploadBioImage = $("#uploadBioImage input[type=file]");

    var btnEditContacts = $("#btnEditContacts");
    var btnEditExperiences = $("#btnEditExperiences");
    var btnAddNewKB = $("#btnAddNewKB");

    var btnAddNewProject = $("#btnAddNewProject");
    var btnAddNewEdu = $("#btnAddNewEdu");

    var btnEditSkills = $("#btnEditSkills");

    var modalEditBio = $("#modalEditBio");
    var modalEditBioImage = $("#modalEditBioImage");
    var modalAddProject = $("#modalAddProject");
    var modalEditProject = $("#modalEditProject");

    var modalAddSkills = $("#modalAddSkills");
    var modalEditSkill = $("#modalEditSkills");

    var modalAddEdu = $("#modalAddEdu");
    var modalEditEdu = $("#modalEditEdu");


    var modalEditConcats = $("#modalEditContacts");

    var modalAddNewKB = $("#modalAddArticle");
    var modalEditKb = $("#modalEditArticle");
    var fileUploadArticleImage = $("#uploadArticleImage input[type=file]");
    var modalUpdateArticleImage = $("#modalEditArticleImage");



    var commentsNotoficationCount = 0;
    var first = true;

    /** Generate Slug */
    var convertToSlug = function ($title, $slug) {
        var str = $('#' + $title).val();

        str = str.replace('-', ' ');
        str = str.replace(/([!?\,\.])/g,' ');
        str = str.trim();

        str = str.replace(/ +/g,'-');
        $('#' + $slug).val(str);
    };


    /** Upload Image to article body*/
    var uploadImageToArticleDesc = function ($image) {
        var data = new FormData();
        data.append("file",$image);
        data.append("_token",csrfToken);
        //alert(csrfToken);
        $.ajax ({
            data: data,
            type: "post",
            url: baseURL + '/image/ajax/upload/article',
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                $('#article-desc').summernote('insertImage',result['image']);
            }
        });
    };




    /** Update Notification regularly*/
    var updateNotification = setInterval(function(){

        updateUnreadComments();

    }, 10000);


    /**
     * Timeline function -> Get (li) return Array
     */
    var liElementToArray = function ($liElement, $order) {
        var $currDataBadge = $liElement.attr('data-badge');
        //var $currDataOrder = $liElement.attr('data-order');
        var $currDataId = $liElement.attr('data-id');
        var $currDataOrder = $order;
        var $currDataYear = $liElement.attr('data-year');
        var $currDataMonth = $liElement.attr('data-month');
        var $currDataName = $liElement.find('h4.timeline-title').html();
        var $currDataLinkAndTime = "&nbsp;" + $liElement.find('span.data-link-and-time').html();
        var $currDataDesc = $liElement.find('div.timeline-body').html();
        var $currFromM = $liElement.attr('data-from-m');
        var $currFromY = $liElement.attr('data-from-y');
        var $currToM = $liElement.attr('data-to-m');
        var $currToY = $liElement.attr('data-to-y');

        var $arr = [
                $currDataBadge,         // 0
                $currDataOrder,         // 1
                $currDataYear,          // 2
                $currDataMonth,         // 3
                $currDataName,          // 4
                $currDataLinkAndTime,   // 5
                $currDataDesc,          // 6
                'false',                // 7 NEW
                $currDataId,            // 8 ID
                $currFromM,             // 9
                $currFromY,             // 10
                $currToM,               // 11
                $currToY                // 12
            ];
        return $arr;
    };


    /**
     *
     * @param $month
     * @returns {string}
     */
    var getMonthName = function ($month) {
        var $m = parseInt($month);
        switch ($m){
            case 1:
                return month_1;
            case 2:
                return month_2;
            case 3:
                return month_3;
            case 4:
                return month_4;
            case 5:
                return month_5;
            case 6:
                return month_6;
            case 7:
                return month_7;
            case 8:
                return month_8;
            case 9:
                return month_9;
            case 10:
                return month_10;
            case 11:
                return month_11;
            case 12:
                return month_12;
            default:
                return $month;
        };
    };




    /**
     *
     * @param $jsonData
     */
    var jsonDataToArray = function ($newMember, $order) {

        var $name = $newMember['name'];
        var $badge = $newMember['badge'];
        var $from_year = $newMember['from_year'];
        var $from_month = $newMember['from_month'];
        var $to_year = $newMember['to_year'];
        var $to_month = $newMember['to_month'];
        var $link = $newMember['link'];
        var $description = $newMember['description'];
        var $to_m = $newMember['to_m'];
        var $to_y = $newMember['to_y'];
        var $id = $newMember['id'];



        var $dataLinkAndTime = '';
        $dataLinkAndTime = getMonthName($from_month) + " " + $from_year;//"Mar. 2001 -  Apr. 2004 ";
        if ($to_month != false){
            $dataLinkAndTime += " - " + getMonthName($to_month) + " " + $to_year;
        } else {
            $dataLinkAndTime += " - " + month_now;
        }

        if ($link != false){
            $dataLinkAndTime += '&nbsp;<a href="'+$link+'" target="_blank" title="'+$name+'">'+$link+'</a>';
        }

        var $arr = [
            $badge,                 // 0
            $order,                 // 1
            $to_y,                  // 2
            $to_m,                  // 3
            $name,                  // 4
            $dataLinkAndTime,       // 5
            $description,           // 6
            'true',                 // 7 NEW
            $id,                    // 8 ID
            $from_month,            // 9
            $from_year,             // 10
            $to_m,                  // 11
            $to_month               // 12
        ];

        return $arr;
    };


    /**
     * Timeline function -> Add New Item
     */
    var AddStoredItemToTimeline = function ($timeLineDiv,$newMember, $loading, $id_name) {

        var $items = [];
        var $itemAdded = false;

        var $orderPlus = 1;

        var $badge = $newMember['badge'];

        var $to_m = $newMember['to_m'];
        var $to_y = $newMember['to_y'];

        var $liCount = $( $timeLineDiv +" li" ).length;

        if ($liCount > 0){
            $($timeLineDiv + ' li[data-badge="true"]').each(function () {
                $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                $items.push(liElementToArray($(this), $orderPlus++));
            });

            if ($badge == true){ // IF new member is CURRENT timeline will set 1 for (orderPlus)
                $items.push(jsonDataToArray($newMember, $orderPlus++));
                $itemAdded = true;

                // Add Others
                $($timeLineDiv + ' li[data-badge="false"]').each(function () {
                    $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                    $items.push(liElementToArray($(this), $orderPlus++));
                });


            } else {

                $($timeLineDiv + ' li[data-badge="false"]').each(function () {
                    var $dataSkip = $(this).attr('data-skip'); // SKIP IF Parsed;
                    if ($dataSkip == 'false'){ //Check for Skip search
                        var $month = $(this).attr('data-month');
                        var $year = $(this).attr('data-year');
                        $year = parseInt($year);
                        //$month = parseInt($month);
                        var $order = $(this).attr('data-order');

                        if (parseInt($to_y) == parseInt($year)){ // Item Year = Year
                            $($timeLineDiv + ' li[data-year="'+$year+'"]').each(function () {
                                if ($(this).attr('data-skip') == 'false'){
                                    var $month = $(this).attr('data-month');
                                    $month = parseInt($month);

                                    // Item Year = Year | Item Month >= Month
                                    if (parseInt($to_m) >= $month && $itemAdded == false){
                                        $items.push(jsonDataToArray($newMember, $orderPlus++));
                                        $itemAdded = true;

                                        $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                                        $items.push(liElementToArray($(this), $orderPlus++));
                                    }
                                    // Item Year = Year | Item Month < Month
                                    else {
                                        var $checkDataSkip = $(this).attr('data-skip');
                                        if ($checkDataSkip == 'false'){
                                            $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                                            $items.push(liElementToArray($(this), $orderPlus++));
                                        }
                                    }
                                }

                            });
                        }

                        if (parseInt($to_y) > $year  && $itemAdded == false) { // Item Year > Year
                            // Add Both -> New Item and The current loop item
                            $items.push(jsonDataToArray($newMember, $orderPlus++));
                            $itemAdded = true;
                            $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                            $items.push(liElementToArray($(this), $orderPlus++));
                        } else {
                            var $checkDataSkip = $(this).attr('data-skip');
                            if ($checkDataSkip == 'false'){
                                $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                                $items.push(liElementToArray($(this), $orderPlus++));
                            }
                        }

                    }

                });


                if ($itemAdded == false){
                    // Add Just -> New Item
                    $items.push(jsonDataToArray($newMember, $orderPlus++));
                    $itemAdded = true;
                }
            }
        } else {
            $($timeLineDiv).removeClass('hidden');
            $items.push(jsonDataToArray($newMember, $orderPlus++));
            $itemAdded = true;
        }


        reRenderTimeline($timeLineDiv, $items, $loading, $id_name);


    };

    /** Re Render Timeline*/
    var reRenderTimeline = function ($timeLineDiV, $items, $loading, $id_name) {
        /**
         * $badge,                 // 0
         $order,                 // 1
         $to_y,                  // 2
         $to_m,                  // 3
         $name,                  // 4
         $dataLinkAndTime,       // 5
         $description            // 6
         Is it new Item?         // 7
         ID                      // 8
         currFromM,              // 9
         $currFromY,             // 10
         $currToM,               // 11
         $currToY                // 12
         */
        $($loading).removeClass('hidden');

        var $html = '';
        for (var $i=0; $i<$items.length; $i++){
            if ($i % 2 == 0){
                if ($items[$i][7] == 'true'){
                    $html += '<li class="timeline-inverted new-item"';
                } else {
                    $html += '<li class="timeline-inverted"';
                }
            } else {
                if ($items[$i][7] == 'true'){
                    $html += '<li class="new-item"';
                } else {
                    $html += '<li ';
                }

            }

            if (isRTL == 1){
                $html += ' style="direction:rtl;text-align:right;"';
            }

            $html += ' data-id="' + $items[$i][8] + '"';
            $html += ' data-from-m="'+$items[$i][9]+'"';
            $html += ' data-from-y="'+$items[$i][10]+'"';
            $html += ' data-to-m="'+$items[$i][11]+'"';
            $html += ' data-to-y="'+$items[$i][12]+'"';
            $html += ' id="'+$id_name+'-id-'+$items[$i][8]+'"';

            if ($items[$i][7] == 'true'){
                $html += ' data-new-item="true"';
            }

            if ($items[$i][0] == 'true') {
                $html += ' data-year="now" data-month="now" data-order="' + ($i+1) + '" data-badge="true" data-skip="false"> ';
                $html += '<div class="timeline-badge">' + month_now + '</div>';
            } else if ($items[$i][0] == true)  {
                $html += ' data-year="now" data-month="now" data-order="' + ($i+1) + '" data-badge="true" data-skip="false"> ';
                $html += '<div class="timeline-badge">' + month_now + '</div>';
            } else {
                //alert($items[$i][2]);
                $html += ' data-year="'+ $items[$i][2] +'" data-month="'+ $items[$i][3] +'" data-order="' + ($i+1) + '" data-badge="false" data-skip="false">';
                $html += '<div class="timeline-badge">' + $items[$i][2] + '</div>';
            }
            $html += '<div class="timeline-panel">';
            $html += '  <div class="timeline-heading">';
            $html += '      <h4 class="timeline-title">'+ $items[$i][4];
            if ($items[$i][7] == 'true'){
                $html += '          <a class="btn btn-info btn-edit-project" href="javascript:void(0);" data-id="'+ $items[$i][8] +'">';
                $html += '              <i class="fa fa-edit"></i>';
                $html += '          </a>';
                $html += '          <a class="btn btn-danger btn-del-project" href="javascript:void(0);" data-id="'+ $items[$i][8] +'" data-del-prj="true" >';
                $html += '              <i class="fa fa-trash"></i>';
                $html += '          </a>';
            }
            $html += '      </h4>';
            $html += '      <p>';
            $html += '          <small class="text-muted">';
            $html += '              <i class="glyphicon glyphicon-time"></i>';
            $html += '              <span class="data-link-and-time">'+ $items[$i][5] +'</span>';
            $html += '          </small>';
            $html += '      </p>';
            $html += '  </div>';
            $html += '  <div class="timeline-body">';
            $html += '      <p>'+ $items[$i][6] +'</p>';
            $html += '  </div>';
            $html += '</div>';
            $html += '</li>';
        }

        $($timeLineDiV).empty();
        $($timeLineDiV).html($html);

        var $liCount = $($timeLineDiV +" li" ).length;

        $($loading).addClass('hidden');

        if ($liCount > 0){
            $($timeLineDiV).removeClass('hidden');
        } else {
            $($timeLineDiV).addClass('hidden');
        }


    };



    /** Update Comment Notification - Ajax */
    var updateUnreadComments = function () {
        $.ajax({
            url: baseURL + '/comment/update/unread',
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                var commentCount = data['count'];
                var htmlNot = data['htmlIcon'];
                var htmlMsg = data['html'];
                $("#not-flag-count").html(commentCount);
                $("#not-icon").html(htmlNot);
                $("#not-comments").html(htmlMsg);

                if (!first) {
                    if (commentCount > 0 && commentsNotoficationCount < commentCount) {
                        $("#notofication-menu").notify(data['notify'], {
                            globalPosition: notifyPosition,
                            className: 'info',
                            autoHideDelay: 4000
                        });
                    }
                    commentsNotoficationCount = commentCount;
                } else {
                    commentsNotoficationCount = commentCount;
                    first = false;
                }

            }
        })
    };








    /*****
     *
     *
     *
     * BEGIN BIO
     *
     *
     *
     * */
    btnEditBio.click(function () {
        $("#modalEditBio .loading").removeClass('hidden');
        $("#btnSaveBio").addClass('hidden');
        var options =  {
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl']],
                ['insert', ['link','hr']],
                ['view', ['codeview']]
            ]
        };
        $("#txtBio").summernote(options);

        $.ajax({
            type:"post",
            url: baseURL + "/bio/ajax/get",
            data: {
                "_token": csrfToken
            },
            success: function (data) {
                $("#txtBio").summernote('code',data["bio"]);
                $("#modalEditBio").attr('data-bio-id',data['id']);
                $("#modalEditBio .loading").addClass('hidden');
                $("#btnSaveBio").removeClass('hidden');
            },
            error: function (error) {
                //location.reload();
            }
        });

        modalEditBio.modal();
    });

    /** Save BIO */
    $("#btnSaveBio").click(function () {
        $(".error").addClass('hidden');
        $("#modalEditBio .loading").removeClass('hidden');
        $("#btnSaveBio").addClass('hidden');


        var bio = $("#txtBio").summernote('code');
        var bioId = $("#modalEditBio").attr('data-bio-id');
        if(!bioId){
            bioId = null;
        }

        $.ajax({
            type: "post",
            url: baseURL + "/bio/ajax/set",
            data: {
                "_token": csrfToken,
                "id": bioId,
                "bio": bio
            },
            success: function (data) {
                $("#modalEditBio .loading").addClass('hidden');
                $("#btnSaveBio").removeClass('hidden');
                $("#bio-para").html(bio);
                modalEditBio.modal('hide');
            },
            error: function (data) {
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditBio .loading").addClass('hidden');
                $("#btnSaveBio").removeClass('hidden');
            }
        });
    });

    /** Save BIO IMAGE **/
    btnEditBioImage.click(function () {
        $("#imgPrev").attr('src', $("#imgBio").attr('src'));
        $("#aPrev").attr('href', $("#imgBio").attr('src'));
        $('#progressBar').html(" ");
        $('#progressBar').width("0");
        modalEditBioImage.modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    /** File Upload - Bio Image */
    fileUploadBioImage.change(function () {
        var fileInput = $(this);
        var urlToUpload = baseURL + "/image/ajax/set/bio";

        $("#modalEditBioImage .loading").removeClass('hidden');

        $(this).simpleUpload(urlToUpload, {
            limit: 1,
            allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
            allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
            maxFileSize: "{{ getMaxContentImageSize() }}",
            data: {
                '_token': csrfToken
            },
            start: function(file){
                //upload started
                $('#progressBar').width(0);
                $('#progressBar').html("");

                $(fileInput).attr('disabled', 'disabled');
            },
            progress: function(progress){
                //received progress
                $('#progressBar').html(Math.round(progress) + "%");
                $('#progressBar').width(progress + "%");
            },
            success: function(data){
                $('#imgPrev').attr('src', data['image']);
                $('#aPrev').attr('href', data['image']);
                $("#imgBio").attr('src', data['image']);
                $("#modalEditBioImage .loading").addClass('hidden');
                modalEditBioImage.modal('hide');
                this.upload.cancel();

            },
            error: function(error){
                //upload failed
                $("#modalEditBioImage .loading").addClass('hidden');
                $('#progressBar').html( + error.name + ": " + error.message);
            }
        });
    });
    /**
     *
     *
     * E N D BIO
     *
     *
     * */





    /**
     *
     *
     * BEGIN PROJECT
     *
     *
     * */
    /** OPEN MODAL */
    btnAddNewProject.click(function () {
        var options =  {
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl']],
                ['view', ['codeview']]
            ]
        };

        $("#new-proj-description").summernote(options);
        $("#modalAddProject .loading").addClass('hidden');
        $("#btnSaveNewProject").removeClass('hidden');
        $(".error ul").empty();
        $("#name").val("");
        $("#from_year").val("");
        $("#from_month").select2("val", "1");
        $("#to_year").val("");
        $("#to_month").select2("val", "1");
        $("#link").val("");
        $("#new-proj-description").summernote('code', "");
        $('#is_present').iCheck('uncheck');
        $("#is_present").attr('data-checked', 'null');
        $("#to_year").removeAttr('disabled');
        $("#to_month").removeAttr('disabled');
        $(".error").addClass('hidden');

        modalAddProject.modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Save New Project */
    $("#btnSaveNewProject").click(function () {

        $("#btnSaveNewProject").addClass('hidden');
        $("#modalAddProject .loading").removeClass('hidden');
        $("#modalAddProject .error ul").empty();

        var pr_name = $("#name").val();
        var from_y = $("#from_year").val();
        var from_m = $("#from_month").val();
        var to_y = $("#to_year").val();
        var to_m = $("#to_month").val();
        var pr_link = $("#link").val();
        var desc = $("#new-proj-description").summernote('code');
        var isPresent = $("#is_present").attr('data-checked');
        var postData = {};
        if (isPresent != 'null'){
            to_y = '1700';
            to_m = '01';
            isPresent = 1;
        } else {
            isPresent = 2;
        }
        if (pr_link == null || pr_link == ''){
            postData = {
                "_token": csrfToken,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "description" : desc,
                "is_present" : isPresent
            };
        } else {
            postData = {
                "_token": csrfToken,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "link": pr_link,
                "description" : desc,
                "is_present" : isPresent
            };
        }
        $.ajax({
            type: "post",
            url: baseURL + '/project/ajax/new',
            data: postData,
            success: function (data) {
                modalAddProject.modal('hide');

                AddStoredItemToTimeline("#project-timeline", data, "#projectSection .loading", "prj");

            }, error: function (data) {
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalAddProject .loading").addClass('hidden');
                $("#btnSaveNewProject").removeClass('hidden');
            }
        });
        
    });


    $("#btnEditProject").click(function () {
        $("#btnEditProject").addClass('hidden');
        $("#modalEditProject .loading").removeClass('hidden');
        $("#modalEditProject .error ul").empty();

        var projectId = $("#modalEditProject").attr('data-prj-id');

        var pr_name = $("#edit-name").val();
        var from_y = $("#edit-from_year").val();
        var from_m = $("#edit-from_month").val();
        var to_y = $("#edit-to_year").val();
        var to_m = $("#edit-to_month").val();
        var pr_link = $("#edit-link").val();
        var desc = $("#edit-proj-description").summernote('code');
        var isPresent = $("#edit-is_present").attr('data-checked');
        var postData = {};
        if (isPresent != 'null'){
            to_y = '1700';
            to_m = '01';
            isPresent = 1;
        } else {
            isPresent = 2;
        }
        if (pr_link == null || pr_link == ''){
            postData = {
                "_token": csrfToken,
                "id": projectId,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "description" : desc,
                "is_present" : isPresent
            };
        } else {
            postData = {
                "_token": csrfToken,
                "id": projectId,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "link": pr_link,
                "description" : desc,
                "is_present" : isPresent
            };
        }
        $.ajax({
            type: "post",
            url: baseURL + "/project/ajax/update/" + projectId,
            data: postData,
            success: function (data) {

                modalEditProject.modal('hide');
                var liId = '#prj-id-' + projectId;
                $(liId).remove(); // Remove Updated Project

                AddStoredItemToTimeline("#project-timeline", data, "#projectSection .prj-loading", "prj");

            }, error: function (data) {
                var errors = data.responseJSON;
                $("#modalEditProject .error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $("#modalEditProject .error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditProject .loading").addClass('hidden');
                $("#btnEditProject").removeClass('hidden');
            }
        });
    });

    /** IS Present - Enable / Disable To(Month & Year)*/
    /** Add new project */
    $('#is_present').on('ifChecked', function(event){
        $("#is_present").attr('data-checked', 1);

        $("#to_year").attr('disabled', 'disabled');
        $("#to_month").attr('disabled', 'disabled');
    });
    $('#is_present').on('ifUnchecked', function(event){
        $("#is_present").attr('data-checked', 'null');
        $("#to_year").removeAttr('disabled');
        $("#to_month").removeAttr('disabled');
    });


    /** IS Present - Enable / Disable To(Month & Year)*/
    /** Edit project */
    $('#edit-is_present').on('ifChecked', function(event){
        $("#edit-is_present").attr('data-checked', 1);

        $("#edit-to_year").attr('disabled', 'disabled');
        $("#edit-to_month").attr('disabled', 'disabled');
    });
    $('#edit-is_present').on('ifUnchecked', function(event){
        $("#edit-is_present").attr('data-checked', 'null');
        $("#edit-to_year").removeAttr('disabled');
        $("#edit-to_month").removeAttr('disabled');
    });




    /** Edit a Project - OPEN MODAL */
    $('#project-timeline').on('click', '.btn-edit-project', function(){
        var projectId = $(this).attr('data-id');

        var liId = '#prj-id-' + projectId;
        var url = baseURL + '/project/ajax/update/' + projectId;

        $("#modalEditProject").attr('data-prj-id', projectId);

        var getName='';
        var getFromMonth='';
        var getFromYear='';
        var getToYear='';
        var getToMonth='';
        var getBadge=false;
        var getLink=false;
        var getDesc=''


        /* Get Data From Server */
        $("#btnEditProject").addClass('hidden');
        $("#modalEditProject .loading").removeClass('hidden');

        /* Show Default Modal */
        $("#modalEditProject .error ul").empty();
        $("#edit-name").val("");
        $("#edit-from_year").val("");
        $("#edit-from_month").select2("val", "1");
        $("#edit-to_year").val("");
        $("#edit-to_month").select2("val", "1");
        $("#edit-link").val("");

        var options =  {
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl']],
                ['view', ['codeview']]
            ]
        };
        $("#edit-proj-description").summernote(options);
        $("#edit-new-proj-description").summernote('code', "");
        $('#edit-is_present').iCheck('uncheck');
        $("#edit-is_present").attr('data-checked', 'null');
        $("#edit-to_year").removeAttr('disabled');
        $("#edit-to_month").removeAttr('disabled');
        $("#edit-proj-description").summernote('code', "");
        $("#modalEditProject.error").addClass('hidden');
        modalEditProject.modal({
            backdrop: 'static',
            keyboard: false
        });


        /* Get Project Info from server - Ajax Request */
        $.ajax({
            type: "post",
            url: baseURL + '/project/ajax/get/' + projectId,
            data: {
                "_token": csrfToken,
                "id": projectId
            },
            success:function (data) {
                getName = data['name'];
                getFromMonth = data['from_m'];
                getFromYear = data['from_y'];
                if (data['badge'] == false){
                    getToMonth = data['to_m'];
                    getToYear = data['to_y'];
                } else {
                    getBadge = true;
                }
                if (data['link'] != false){
                    getLink = data['link'];
                }
                getDesc = data['description'];




                $("#modalEditProject .loading").addClass('hidden');
                $("#btnEditProject").removeClass('hidden');

                $("#modalEditProject .error ul").empty();
                $("#edit-name").val(getName);
                $("#edit-from_year").val(getFromYear);
                $("#edit-from_month").select2("val", getFromMonth);
                if (getBadge == false) {
                    $("#edit-to_year").val(getToYear);
                    $("#edit-to_year").removeAttr('disabled');
                    $("#edit-to_month").removeAttr('disabled');
                    $("#edit-to_month").select2("val", getToMonth);
                    $('#edit-is_present').iCheck('uncheck');
                    $("#edit-is_present").attr('data-checked', 'null');
                } else {
                    $("#edit-to_year").val("");
                    $("#edit-to_month").select2("val", "1");
                    $("#edit-to_year").attr('disabled', 'disabled');
                    $("#edit-to_month").attr('disabled', 'disabled')
                    $('#edit-is_present').iCheck('check');
                    $("#edit-is_present").attr('data-checked', 1);
                }
                if (getLink != false){
                    $("#edit-link").val(getLink);
                } else {
                    $("#edit-link").val("");
                }
                $("#edit-proj-description").summernote('code', getDesc);
                $("#modalEditProject .error").addClass('hidden');



            },
            error:function (data) {
                modalEditProject.modal('hide');
            }
        });


    });



    /** Delete a Project */
    $('#project-timeline').on('click', '.btn-del-project', function(){
        var projectId = $(this).attr('data-id');

        var liId = '#prj-id-' + projectId;
        var url = baseURL + '/project/ajax/remove/' + projectId;
        $.ajax({
            url: url,
            type: "post",
            data: {
                "_token": csrfToken,
                'id': projectId
            },
            success: function (data) {
                if (data["delete"] == true){
                    $(liId).remove();
                    var timeLineDiv = "#project-timeline";
                    var loading = "#projectSection .prj-loading";
                    var order = 1;
                    var items = [];
                    $(timeLineDiv + ' li').each(function () {
                        $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                        items.push(liElementToArray($(this), order++));
                    });
                    reRenderTimeline(timeLineDiv, items, loading, 'prj');
                    return 0;
                }
            },
            error: function (data) {
                alert(unknown_error);
                window.location.reload();
            }
        });

    });

    /**
     *
     *
     * E N D PROJECT
     *
     *
     * */












    /**
     *
     *
     *
     * BEGIN SKILLS
     *
     *
     *
     */


    /** open popup */
    $("#btnAddNewSkill").click(function () {
        $("#modalAddSkills .loading").addClass('hidden');
        $("#btnSaveNewSkill").removeClass('hidden');
        $("#modalAddSkills .error ul").empty();
        $("#skill").val("");
        $("#color").select2("val", "5");
        $("#percentage").val("");
        $("#modalAddSkills .error").addClass('hidden');

        modalAddSkills.modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Save New Skill */
    $("#btnSaveNewSkill").click(function () {

        $("#modalAddSkills .loading").addClass('hidden');
        $("#btnSaveNewSkill").removeClass('hidden');
        $("#modalAddSkills .error ul").empty();

        var pSkill = $("#skill").val();
        var pColor = $("#color").val();
        var pPercent = $("#percentage").val();



        var postData = {
            "_token": csrfToken,
            "skill" : pSkill,
            "color" : pColor,
            "percentage" : pPercent
        };
        $.ajax({
            type: "post",
            url: baseURL + '/skill/ajax/new',
            data: postData,
            success: function (data) {
                modalAddSkills.modal('hide');

                var dataHTMLSkill = '';

                dataHTMLSkill = '<div class="col-sm-6 col-md-4" id="skill-'+ data['id'] +'">';
                dataHTMLSkill += '  <div class="btn-group pull-right " style="margin-top: 4px">';
                dataHTMLSkill += '      <a data-id="'+data['id']+'" class="btn btn-info btn-edit-skill" href="javascript:void(0);">';
                dataHTMLSkill += '          <i class="fa fa-edit"></i>';
                dataHTMLSkill += '      </a>';
                dataHTMLSkill += '      <a data-id="'+data['id']+'" class="btn btn-danger btn-del-skill" href="javascript:void(0);">';
                dataHTMLSkill += '          <i class="fa fa-trash"></i>';
                dataHTMLSkill += '      </a>';
                dataHTMLSkill += '  </div>';
                dataHTMLSkill += '  <div class="progress" >';
                dataHTMLSkill += '      <div class="progress-bar progress-bar-striped '+ data['color_css_class'] +'" role="progressbar" aria-valuenow="'+data['percentage']+'" aria-valuemin="0" aria-valuemax="100" style="width:'+data['percentage']+'%"> </div>';
                dataHTMLSkill += '  </div>';
                dataHTMLSkill += '<div class="progress-text" title="'+data['skill']+'">'+data['skill']+'</div>';
                dataHTMLSkill += '</div>';

                var currentHtmlData = $("#skill-container").html();

                $("#skill-container").html(dataHTMLSkill + currentHtmlData);



            }, error: function (data) {
                var errors = data.responseJSON;
                $("#modalAddSkills .error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $("#modalAddSkills .error ul").append("<li>" + val + "</li>");
                });
                $("#modalAddSkills .loading").addClass('hidden');
                $("#btnSaveNewSkill").removeClass('hidden');
            }
        });

    });

    /** Edit Skill */
    $("#btnEditSkill").click(function () {
        $("#btnEditSkill").addClass('hidden');
        $("#modalEditSkills .loading").removeClass('hidden');
        $("#modalEditSkills .error ul").empty();

        var skillId = $("#modalEditSkills").attr('data-skill-id');

        var sk_skill = $("#edit-skill").val();
        var sk_percentage = $("#edit-percentage").val();
        var sk_color = $("#edit-color").val();

        var postData = {
                "_token": csrfToken,
                "id": skillId,
                "skill" : sk_skill,
                "color" : sk_color,
                "percentage" : sk_percentage,

            };

        $.ajax({
            type: "post",
            url: baseURL + "/skill/ajax/update/" + skillId,
            data: postData,
            success: function (data) {

                modalEditSkill.modal('hide');
                var divId = '#skill-' + skillId;
                $(divId + ' [role="progressbar"').attr('class', 'progress-bar progress-bar-striped ' + data['color_css_class']);

                $(divId + ' [role="progressbar"').attr('aria-valuenow', '0');
                $(divId + ' [role="progressbar"').attr('style', 'width:0' );

                $(divId + ' [role="progressbar"').attr('aria-valuenow', data['percentage']);
                $(divId + ' [role="progressbar"').attr('style', 'width:' + data['percentage'] + '%');

                $(divId + " .progress-text").attr('title',data['skill']);
                $(divId + " .progress-text").html(data['skill']);


            }, error: function (data) {
                var errors = data.responseJSON;
                $("#modalEditSkills .error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $("#modalEditSkills .error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditSkills .loading").addClass('hidden');
                $("#btnEditSkill").removeClass('hidden');
            }
        });
    });


    /** Edit a Skill - OPEN MODAL */
    $('#skill-container').on('click', '.btn-edit-skill', function(){
        var skillId = $(this).attr('data-id');

        var divSkill = '#skill-' + skillId;
        var url = baseURL + '/skill/ajax/update/' + skillId;

        $("#modalEditSkills").attr('data-skill-id', skillId);

        var getTitle='';
        var getColor='';
        var getPercentage='';


        /* Get Data From Server */
        $("#btnEditSkill").addClass('hidden');
        $("#modalEditSkills .loading").removeClass('hidden');

        /* Show Default Modal */
        $("#modalEditSkills .error ul").empty();
        $("#edit-skill").val("");
        $("#edit-color").select2("val", "1");
        $("#edit-percentage").val("");

        modalEditSkill.modal({
            backdrop: 'static',
            keyboard: false
        });


        /* Get Project Info from server - Ajax Request */
        $.ajax({
            type: "post",
            url: baseURL + '/skill/ajax/get/' + skillId,
            data: {
                "_token": csrfToken,
                "id": skillId
            },
            success:function (data) {
                getTitle = data['skill'];
                getColor = data['color'];
                getPercentage = data['percentage'];

                $("#modalEditSkills .loading").addClass('hidden');
                $("#btnEditSkill").removeClass('hidden');

                $("#modalEditSkills .error ul").empty();
                $("#edit-skill").val(getTitle);

                $("#edit-color").select2("val", getColor.toString());
                $("#edit-percentage").val(getPercentage);

                $("#modalEditSkills .error").addClass('hidden');

            },
            error:function (data) {
                modalEditSkill.modal('hide');
            }
        });


    });

    /** Delete a Skill */
    $('#skill-container').on('click', '.btn-del-skill', function(){
        var skillId = $(this).attr('data-id');

        $(".skill-loading").removeClass('hidden');

        var skillDiv = '#skill-' + skillId;
        var url = baseURL + '/skill/ajax/remove/' + skillId;
        $.ajax({
            url: url,
            type: "post",
            data: {
                "_token": csrfToken,
                'id': skillId
            },
            success: function (data) {
                if (data["delete"] == true){
                    $(skillDiv).remove();
                    $(".skill-loading").addClass('hidden');
                    return 0;
                }
            },
            error: function (data) {
                alert(unknown_error);
                window.location.reload();
            }
        });

    });






    /**
     *
     *
     *
     * E N D SKILLS
     *
     *
     *
     */








    /**
     *
     *
     * BEGIN Education and Experiences
     *
     *
     * */
    /** OPEN MODAL */
    btnAddNewEdu.click(function () {
        var options =  {
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl']],
                ['view', ['codeview']]
            ]
        };

        $("#edu-new-proj-description").summernote(options);
        $("#modalAddEdu .loading").addClass('hidden');
        $("#btnSaveNewEdu").removeClass('hidden');
        $(".error ul").empty();
        $("#edu-name").val("");
        $("#edu-from_year").val("");
        $("#edu-from_month").select2("val", "1");
        $("#edu-to_year").val("");
        $("#edu-to_month").select2("val", "1");
        $("#edu-link").val("");
        $("#edu-new-proj-description").summernote('code', "");
        $('#edu-is_present').iCheck('uncheck');
        $("#edu-is_present").attr('data-checked', 'null');
        $("#edu-to_year").removeAttr('disabled');
        $("#edu-to_month").removeAttr('disabled');
        $(".error").addClass('hidden');

        modalAddEdu.modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Save New Education and Experiences */
    $("#btnSaveNewEdu").click(function () {

        $("#btnSaveNewEdu").addClass('hidden');
        $("#modalAddEdu .loading").removeClass('hidden');
        $("#modalAddEdu .error ul").empty();

        var pr_name = $("#edu-name").val();
        var from_y = $("#edu-from_year").val();
        var from_m = $("#edu-from_month").val();
        var to_y = $("#edu-to_year").val();
        var to_m = $("#edu-to_month").val();
        var pr_link = $("#edu-link").val();
        var desc = $("#edu-new-proj-description").summernote('code');
        var isPresent = $("#edu-is_present").attr('data-checked');
        var postData = {};
        if (isPresent != 'null'){
            to_y = '1700';
            to_m = '01';
            isPresent = 1;
        } else {
            isPresent = 2;
        }
        if (pr_link == null || pr_link == ''){
            postData = {
                "_token": csrfToken,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "description" : desc,
                "is_present" : isPresent
            };
        } else {
            postData = {
                "_token": csrfToken,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "link": pr_link,
                "description" : desc,
                "is_present" : isPresent
            };
        }
        $.ajax({
            type: "post",
            url: baseURL + '/edu/ajax/new',
            data: postData,
            success: function (data) {
                modalAddEdu.modal('hide');

                AddStoredItemToTimeline("#edu-timeline", data, "#eduSection .loading", "edu");

            }, error: function (data) {
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalAddEdu .loading").addClass('hidden');
                $("#btnSaveNewEdu").removeClass('hidden');
            }
        });

    });


    $("#btnEditEdu").click(function () {
        $("#btnEditEdu").addClass('hidden');
        $("#modalEditEdu .loading").removeClass('hidden');
        $("#modalEditEdu .error ul").empty();

        var projectId = $("#modalEditEdu").attr('data-prj-id');

        var pr_name = $("#edit-edu-name").val();
        var from_y = $("#edit-edu-from_year").val();
        var from_m = $("#edit-edu-from_month").val();
        var to_y = $("#edit-edu-to_year").val();
        var to_m = $("#edit-edu-to_month").val();
        var pr_link = $("#edit-edu-link").val();
        var desc = $("#edit-edu-proj-description").summernote('code');
        var isPresent = $("#edit-edu-is_present").attr('data-checked');
        var postData = {};
        if (isPresent != 'null'){
            to_y = '1700';
            to_m = '01';
            isPresent = 1;
        } else {
            isPresent = 2;
        }
        if (pr_link == null || pr_link == ''){
            postData = {
                "_token": csrfToken,
                "id": projectId,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "description" : desc,
                "is_present" : isPresent
            };
        } else {
            postData = {
                "_token": csrfToken,
                "id": projectId,
                "name" : pr_name,
                "from_year" : from_y,
                "from_month" : from_m,
                "to_year" : to_y,
                "to_month" : to_m,
                "link": pr_link,
                "description" : desc,
                "is_present" : isPresent
            };
        }
        $.ajax({
            type: "post",
            url: baseURL + "/edu/ajax/update/" + projectId,
            data: postData,
            success: function (data) {

                modalEditEdu.modal('hide');
                var liId = '#edu-id-' + projectId;
                $(liId).remove(); // Remove Updated Project

                AddStoredItemToTimeline("#edu-timeline", data, "#eduSection .edu-loading", "edu");

            }, error: function (data) {
                var errors = data.responseJSON;
                $("#modalEditEdu .error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $("#modalEditEdu .error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditEdu .loading").addClass('hidden');
                $("#btnEditEdu").removeClass('hidden');
            }
        });
    });

    /** IS Present - Enable / Disable To(Month & Year)*/
    /** Add new Education and Experiences */
    $('#edu-is_present').on('ifChecked', function(event){
        $("#edu-is_present").attr('data-checked', 1);

        $("#edu-to_year").attr('disabled', 'disabled');
        $("#edu-to_month").attr('disabled', 'disabled');
    });
    $('#edu-is_present').on('ifUnchecked', function(event){
        $("#edu-is_present").attr('data-checked', 'null');
        $("#edu-to_year").removeAttr('disabled');
        $("#edu-to_month").removeAttr('disabled');
    });


    /** IS Present - Enable / Disable To(Month & Year)*/
    /** Edit Education and Experiences */
    $('#edit-edu-is_present').on('ifChecked', function(event){
        $("#edit-edu-is_present").attr('data-checked', 1);

        $("#edit-edu-to_year").attr('disabled', 'disabled');
        $("#edit-edu-to_month").attr('disabled', 'disabled');
    });
    $('#edit-edu-is_present').on('ifUnchecked', function(event){
        $("#edit-edu-is_present").attr('data-checked', 'null');
        $("#edit-edu-to_year").removeAttr('disabled');
        $("#edit-edu-to_month").removeAttr('disabled');
    });




    /** Edit an Education and Experiences - OPEN MODAL */
    $('#edu-timeline').on('click', '.btn-edit-project', function(){
        var projectId = $(this).attr('data-id');

        var liId = '#edu-id-' + projectId;
        var url = baseURL + '/edu/ajax/update/' + projectId;

        $("#modalEditEdu").attr('data-prj-id', projectId);

        var getName='';
        var getFromMonth='';
        var getFromYear='';
        var getToYear='';
        var getToMonth='';
        var getBadge=false;
        var getLink=false;
        var getDesc=''


        /* Get Data From Server */
        $("#btnEditEdu").addClass('hidden');
        $("#modalEditEdu .loading").removeClass('hidden');

        /* Show Default Modal */
        $("#modalEditEdu .error ul").empty();
        $("#edit-edu-name").val("");
        $("#edit-edu-from_year").val("");
        $("#edit-edu-from_month").select2("val", "1");
        $("#edit-edu-to_year").val("");
        $("#edit-edu-to_month").select2("val", "1");
        $("#edit-edu-link").val("");

        var options =  {
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl']],
                ['view', ['codeview']]
            ]
        };
        $("#edit-edu-proj-description").summernote(options);
        $("#edit-edu-new-proj-description").summernote('code', "");
        $('#edit-edu-is_present').iCheck('uncheck');
        $("#edit-edu-is_present").attr('data-checked', 'null');
        $("#edit-edu-to_year").removeAttr('disabled');
        $("#edit-edu-to_month").removeAttr('disabled');
        $("#edit-edu-proj-description").summernote('code', "");
        $("#modalEditEdu .error").addClass('hidden');
        modalEditEdu.modal({
            backdrop: 'static',
            keyboard: false
        });


        /* Get Info from server - Ajax Request */
        $.ajax({
            type: "post",
            url: baseURL + '/edu/ajax/get/' + projectId,
            data: {
                "_token": csrfToken,
                "id": projectId
            },
            success:function (data) {
                getName = data['name'];
                getFromMonth = data['from_m'];
                getFromYear = data['from_y'];
                if (data['badge'] == false){
                    getToMonth = data['to_m'];
                    getToYear = data['to_y'];
                } else {
                    getBadge = true;
                }
                if (data['link'] != false){
                    getLink = data['link'];
                }
                getDesc = data['description'];




                $("#modalEditEdu .loading").addClass('hidden');
                $("#btnEditEdu").removeClass('hidden');

                $("#modalEditEdu .error ul").empty();
                $("#edit-edu-name").val(getName);
                $("#edit-edu-from_year").val(getFromYear);
                $("#edit-edu-from_month").select2("val", getFromMonth);
                if (getBadge == false) {
                    $("#edit-edu-to_year").val(getToYear);
                    $("#edit-edu-to_year").removeAttr('disabled');
                    $("#edit-edu-to_month").removeAttr('disabled');
                    $("#edit-edu-to_month").select2("val", getToMonth);
                    $('#edit-edu-is_present').iCheck('uncheck');
                    $("#edit-edu-is_present").attr('data-checked', 'null');
                } else {
                    $("#edit-edu-to_year").val("");
                    $("#edit-edu-to_month").select2("val", "1");
                    $("#edit-edu-to_year").attr('disabled', 'disabled');
                    $("#edit-edu-to_month").attr('disabled', 'disabled')
                    $('#edit-edu-is_present').iCheck('check');
                    $("#edit-edu-is_present").attr('data-checked', 1);
                }
                if (getLink != false){
                    $("#edit-edu-link").val(getLink);
                } else {
                    $("#edit-edu-link").val("");
                }
                $("#edit-edu-proj-description").summernote('code', getDesc);
                $("#modaleditedu .error").addClass('hidden');



            },
            error:function (data) {
                modalEditEdu.modal('hide');
            }
        });


    });



    /** Delete an Education and Experiences */
    $('#edu-timeline').on('click', '.btn-del-project', function(){
        var projectId = $(this).attr('data-id');

        var liId = '#edu-id-' + projectId;
        var url = baseURL + '/edu/ajax/remove/' + projectId;
        $.ajax({
            url: url,
            type: "post",
            data: {
                "_token": csrfToken,
                'id': projectId
            },
            success: function (data) {
                if (data["delete"] == true){
                    $(liId).remove();
                    var timeLineDiv = "#edu-timeline";
                    var loading = "#eduSection .edu-loading";
                    var order = 1;
                    var items = [];
                    $(timeLineDiv + ' li').each(function () {
                        $(this).attr('data-skip', 'true'); // SKIP doing anything in near future! :-D
                        items.push(liElementToArray($(this), order++));
                    });
                    reRenderTimeline(timeLineDiv, items, loading, 'edu');
                    return 0;
                }
            },
            error: function (data) {
                alert(unknown_error);
                window.location.reload();
            }
        });

    });

    /**
     *
     *
     * E N D Education and Experiences
     *
     *
     * */





    /**
     *
     *
     * BEGIN Contacts
     *
     *
     *
     */

    /** OPEN MODAL */
    btnEditContacts.click(function () {
        $("#modalEditContacts .loading").addClass('hidden');
        $("#btnSaveContacts").removeClass('hidden');


        $("#modalEditContacts .error ul").empty();
        $("#tell").val(" ");
        $("#email").val(" ");
        $("#fb").val(" ");
        $("#tw").val(" ");
        $("#ytt").val(" ");
        $("#ig").val(" ");
        $("#li").val(" ");
        $("#gh").val(" ");
        $("#tg").val(" ");
        $("#gp").val(" ");
        $("#pi").val(" ");

        $("#modalEditContacts .error").addClass('hidden');


        /** get Data from server **/
        $.ajax({
            type:"post",
            url: baseURL + "/contact/ajax/get",
            data: {
                "_token": csrfToken
            },
            success: function (data) {

                $("#tell").val(data['tell']);
                $("#email").val(data['email']);
                $("#fb").val(data['fb']);
                $("#tw").val(data['tw']);
                $("#ytt").val(data['yt']);
                $("#ig").val(data['ig']);
                $("#li").val(data['li']);
                $("#gh").val(data['gh']);
                $("#tg").val(data['tg']);
                $("#gp").val(data['gp']);
                $("#pi").val(data['pn']);

                $("#modalEditContacts").attr('data-contact-id',data['id']);
                $("#modalEditContacts .loading").addClass('hidden');
                $("#btnSaveContacts").removeClass('hidden');
            },
            error: function (error) {
                //location.reload();
            }
        });


        modalEditConcats.modal({
            backdrop: 'static',
            height: 600,
            keyboard: false
        });
    });
    /** Change Edit Contact modal size - When Opened **/
    $('#modalEditContacts').on('show.bs.modal', function () {
        $('.modal .modal-body').css('overflow-y', 'auto');
        $('.modal .modal-body').css('max-height', $(window).height() * 0.7);
    });


    /** Save Contact */
    $("#btnSaveContacts").click(function () {
        $("#modalEditContacts .error").addClass('hidden');
        $("#modalEditContacts .loading").removeClass('hidden');
        $("#btnSaveContacts").addClass('hidden');

        var contactId = $("#modalEditContacts").attr('data-contact-id');
        if(!contactId){
            contactId = null;
        }

        var needSendAjax = false;
        var dataNeedToSend = {
            "_token": csrfToken,
            "id": contactId
        };


        var tell = (  ($("#tell").val() != '') ? $("#tell").val() : false);
        var email = (  ($("#email").val() != '') ? $("#email").val() : false);
        var fb = (  ($("#fb").val() != '') ? $("#fb").val() : false);
        var tw = (  ($("#tw").val() != '') ? $("#tw").val() : false);
        var ytt = (  ($("#ytt").val() != '') ? $("#ytt").val() : false);
        var ig = (  ($("#ig").val() != '') ? $("#ig").val() : false);
        var li = (  ($("#li").val() != '') ? $("#li").val() : false);
        var gh = (  ($("#gh").val() != '') ? $("#gh").val() : false);
        var tg = (  ($("#tg").val() != '') ? $("#tg").val() : false);
        var gp = (  ($("#gp").val() != '') ? $("#gp").val() : false);
        var pi = (  ($("#pi").val() != '') ? $("#pi").val() : false);



        if (tell) { dataNeedToSend.tell = tell; needSendAjax = true; }
        if (email) { dataNeedToSend.email = email; needSendAjax = true; }
        if (fb) { dataNeedToSend.fb = fb ; needSendAjax = true; }
        if (tw) { dataNeedToSend.tw = tw; needSendAjax = true; }
        if (ytt) { dataNeedToSend.yt = ytt; needSendAjax = true; }
        if (ig) { dataNeedToSend.ig = ig; needSendAjax = true; }
        if (li) { dataNeedToSend.li = li; needSendAjax = true; }
        if (gh) { dataNeedToSend.gh = gh; needSendAjax = true; }
        if (tg) { dataNeedToSend.tg = tg; needSendAjax = true; }
        if (gp) { dataNeedToSend.gp = gp; needSendAjax = true; }
        if (pi) { dataNeedToSend.pn = pi; needSendAjax = true; }



        if (needSendAjax){
            $.ajax({
                type: "post",
                url: baseURL + "/contact/ajax/set",
                data: dataNeedToSend,
                success: function (data) {
                    $("#modalEditContacts .loading").addClass('hidden');
                    $("#btnSaveContacts").removeClass('hidden');

                    /** Tell **/
                    if (data['tell'] != null) {
                        $("#contact-tell").html('<i class="fa fa-phone fa-3x sr-contact"></i><p class="open-sans">' + data['tell'] + '</p>');
                    }else {
                        $("#contact-tell").html(' ');
                    }

                    /** Email **/
                    if (data['email'] != null) {
                        $("#contact-email").html('<i class="fa fa-envelope-o fa-3x sr-contact"></i><p class="open-sans"><a href="mailto:' + data['email'] + '">'+data['email']+'</a></p>');
                    }else {
                        $("#contact-email").html(' ');
                    }

                    /** Facebook */
                    if (data['fb'] != null) {
                        $("#contact-fb").removeClass('hidden');
                        $("#contact-fb").html('<a href="' + data['fb'] + '" class="fb" target="_blank"><i class="fa fa-facebook"></i></a>');
                    }else {
                        $("#contact-fb").addClass('hidden');
                        $("#contact-fb").empty();
                    }

                    /** Twitter */
                    if (data['tw'] != null) {
                        $("#contact-tw").removeClass('hidden');
                        $("#contact-tw").html('<a href="' + data['tw'] + '" class="tw" target="_blank"><i class="fa fa-twitter"></i></a>');
                    }else {
                        $("#contact-tw").addClass('hidden');
                        $("#contact-tw").empty();
                    }


                    /** Youtube */
                    if (data['yt'] != null) {
                        $("#contact-yt").removeClass('hidden');
                        $("#contact-yt").html('<a href="' + data['yt'] + '" class="yt" target="_blank"><i class="fa fa-youtube"></i></a>');
                    }else {
                        $("#contact-yt").addClass('hidden');
                        $("#contact-yt").empty();
                    }

                    /** Instagram */
                    if (data['ig'] != null) {
                        $("#contact-ig").removeClass('hidden');
                        $("#contact-ig").html('<a href="' + data['ig'] + '" class="ig" target="_blank"><i class="fa fa-instagram"></i></a>');
                    }else {
                        $("#contact-ig").addClass('hidden');
                        $("#contact-ig").empty();
                    }

                    /** LinkedIn */
                    if (data['li'] != null) {
                        $("#contact-li").removeClass('hidden');
                        $("#contact-li").html('<a href="' + data['li'] + '" class="tg" target="_blank"><i class="fa fa-linkedin"></i></a>');
                    }else {
                        $("#contact-li").addClass('hidden');
                        $("#contact-li").empty();
                    }

                    /** Pinterest */
                    if (data['pn'] != null) {
                        $("#contact-pn").removeClass('hidden');
                        $("#contact-pn").html('<a href="' + data['pn'] + '" class="pin" target="_blank"><i class="fa fa-pinterest"></i></a>');
                    }else {
                        $("#contact-pn").addClass('hidden');
                        $("#contact-pn").empty();
                    }

                    /** GitHub */
                    if (data['gh'] != null) {
                        $("#contact-gh").removeClass('hidden');
                        $("#contact-gh").html('<a href="' + data['gh'] + '" class="gh" target="_blank"><i class="fa fa-github"></i></a>');
                    }else {
                        $("#contact-gh").addClass('hidden');
                        $("#contact-gh").empty();
                    }


                    /** Telegram */
                    if (data['tg'] != null) {
                        $("#contact-tg").removeClass('hidden');
                        $("#contact-tg").html('<a href="' + data['tg'] + '" class="tg" target="_blank"><i class="fa fa-paper-plane"></i></a>');
                    }else {
                        $("#contact-tg").addClass('hidden');
                        $("#contact-tg").empty();
                    }


                    /** Google Plus */
                    if (data['gp'] != null) {
                        $("#contact-gp").removeClass('hidden');
                        $("#contact-gp").html('<a href="' + data['gp'] + '" class="gp" target="_blank"><i class="fa fa-google-plus"></i></a>');
                    }else {
                        $("#contact-gp").addClass('hidden');
                        $("#contact-gp").empty();
                    }


                    modalEditConcats.modal('hide');
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    $("#modalEditContacts .error").removeClass('hidden');
                    $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                    $.each(errors, function (key, val) {
                        $(".error ul li.unknown-error").remove();
                        $("#modalEditContacts .error ul").append("<li>" + val + "</li>");
                    });
                    $("#modalEditContacts .loading").addClass('hidden');
                    $("#btnSaveContacts").removeClass('hidden');
                }
            });
        } else {
            $("#modalEditContacts .loading").addClass('hidden');
            $("#btnSaveContacts").removeClass('hidden');
        }

    });




    /**
     *
     *
     * E N D Contacts
     *
     *
     *
     */







    /**
     *
     *
     *
     *  BEGIN Article
     *
     *
     */

    /** Open Modal - Add Article */
    btnAddNewKB.click(function () {

        var options =  {
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert',['ltr','rtl', 'link']],
                ['view', ['codeview']],
                ['picture',['picture']]
            ],
            callbacks : {
                onImageUpload: function(image) {
                    uploadImageToArticleDesc(image[0]);
                },
                onMediaDelete: function($target, editor, $editable) {
                    alert($target.context.dataset.filename);
                    $target.remove();
                }
            }
        };

        $("#article-desc").summernote(options);
        $("#article-title").val("");
        $("#article-slug").val("");
        $("#article-summary").val("");
        $('#article-enabled').iCheck('check');
        $("#article-desc").summernote("code", "");
        $('#article-tags').tagsinput('removeAll');


        $("#btnSaveNewArticle").removeClass('hidden');
        $("#modalAddArticle .loading").addClass('hidden');
        $("#modalAddArticle .error").addClass('hidden');
        $("#modalAddArticle .error ul").empty();

        modalAddNewKB.modal({
            backdrop: 'static',
            height: 600,
            keyboard: false
        });
    });


    /** Enable / Disable Article */
    $('#article-enabled').on('ifChecked', function(event){
        $("#article-enabled").attr('data-checked', 1);
    });
    $('#article-enabled').on('ifUnchecked', function(event){
        $("#article-enabled").attr('data-checked', 'null');
    });

    /** Enable / Disable Article */
    $('#article-edit-enabled').on('ifChecked', function(event){
        $("#article-edit-enabled").attr('data-checked', 1);
    });
    $('#article-edit-enabled').on('ifUnchecked', function(event){
        $("#article-edit-enabled").attr('data-checked', 'null');
    });


    $('#modalAddArticle').on('show.bs.modal', function () {
        $('.modal .modal-body').css('overflow-y', 'auto');
        $('.modal .modal-body').css('max-height', $(window).height() * 0.7);
    });


    /** getSlug */
    $("#article-title").change(function () {
        convertToSlug("article-title", "article-slug");
    });

    /** getSlug */
    $("#article-edit-title").change(function () {
        convertToSlug("article-edit-title", "article-edit-slug");
    });




    /** Resize container  event */
    $("#blog-items").on("mresize",function() {
        $kbGrid.masonry();
    }).each(function(){
        $(this).data("mresize").throttle=0;
    });


    /** Add New Article */
    $("#btnSaveNewArticle").click(function () {
        $("#btnSaveNewArticle").addClass('hidden');
        $("#modalAddArticle .loading").removeClass('hidden');
        $("#modalAddArticle .error ul").empty();



        var ar_name = $("#article-title").val();
        var ar_slug = $("#article-slug").val();
        var ar_summary = $("#article-summary").val();
        var ar_desc = $("#article-desc").val();
        var ar_tags = $("#article-tags").val();
        var ar_enabled = $("#article-enabled").attr('data-checked');
        if (ar_enabled != 'null'){
            ar_enabled = 1;
        } else {
            ar_enabled = 2;
        }


        var postData = {
            "_token": csrfToken,
            "title" : ar_name,
            "slug" : ar_slug,
            "summary" : ar_summary,
            "enabled" : ar_enabled,
            "html_desc" : ar_desc,
            "tags": ar_tags
        };


        $.ajax({
            type: "post",
            url: baseURL + '/kb/ajax/new',
            data: postData,
            success: function (data) {
                modalAddNewKB.modal('hide');
                $(".error").addClass('hidden');
                $("#btnSaveNewArticle").removeClass('hidden');
                //AddStoredItemToTimeline("#edu-timeline", data, "#eduSection .loading", "edu");

                var blogId = data['id'];
                var blogTitle = data['title'];
                var blogImage = data['defaultImage'];
                var blogSlug = data['slug'];
                var blogUrl = data['url'];
                var blogBaseUrl = data['baseURL'];
                var blogDate = data['date'];
                var blogReadMore = data['readMore'];
                var blogBody = data['html_desc'];
                var blogEnabled = data['enabled'];
                var blogSummary = data['summary'];
                var blogTags = data['tags'];

                var html = '';
                html += '<div class="col-sm-12 col-md-6 col-lg-4 blog-item" id="article-'+blogId+'" data-kb-id="'+ blogId +'">';
                html += '   <div class="item">';
                html += '       <div class="article-img">';
                html += '           <a href="'+blogUrl+'" title="'+blogTitle+'">';
                html += '               <img src="" class="img-responsive" alt="'+blogTitle+'" />';
                html += '           </a>';
                html += '       </div>';
                html += '       <h2 title="'+blogTitle+'">';
                html += '           <a href="'+blogUrl+'" title="'+blogTitle+'">';
                html += '               <i class="fa fa-newspaper-o"></i>' + blogTitle;
                html += '           </a>';
                html += '       </h2>';
                html += '       <ul class="list-inline article-date-time">';
                html += '           <li class="time"><i class="fa fa-calendar"></i>'+blogDate+'</li>';
                html += '           <li><i class="fa fa-comments"></i>0</li>';
                html += '           <li><i class="fa fa-eye"></i>0</li>';
                html += '       </ul>';
                html += '       <p class="article-body">';
                html += '           ' + blogSummary;
                html += '           <a href="'+blogUrl+'" title="'+blogTitle+'">';
                html += '               ' + blogReadMore;
                html += '           </a>';
                html += '       </p>';
                //BEGIN TAGS
                if (blogTags.length > 0 ) {
                    html += '       <div class="article-tags">';
                    html += '           <ul class="list-inline">';
                    for (var k=0; k < blogTags.length; k++){
                        if (blogTags != '' && blogTags != null){
                            html += '               <li>';
                            html += '                   <a href="'+baseURL+'/hashtag/'+blogTags[k]+'" title="'+blogTags[k]+'"';
                            html += '                       <i class="fa fa-hashtag"></i>';
                            html += '                       ' + blogTags[k];
                            html += '                   </a>';
                            html += '               </li>';
                        }
                    }
                    html += '           </ul>';
                    html += '       </div>';
                }
                //E N D TAGS
                html += '       <div class="article-btn text-center">';
                html += '           <a class="btn btn-success btn-img-article" href="javascript:void(0);" data-id="'+blogId+'"><i class="fa fa-image"></i></a>';
                html += '           <a class="btn btn-info btn-edit-article" href="javascript:void(0);" data-id="'+blogId+'"><i class="fa fa-edit"></i></a>';
                html += '           <a class="btn btn-primary btn-comment-article" href="javascript:void(0);" data-id="'+blogId+'"><i class="fa fa-comments"></i></a>';
                if (blogEnabled == 1) {
                    html += '           <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="1" data-id="'+blogId+'"><i class="fa fa-eye-slash"></i></a>';
                } else {
                    html += '           <a class="btn btn-warning btn-enabled-article" href="javascript:void(0);" data-enabled="2" data-id="'+blogId+'"><i class="fa fa-eye"></i></a>';
                }

                html += '           <a class="btn btn-danger btn-delete-article" href="javascript:void(0);" data-id="'+blogId+'"><i class="fa fa-trash"></i></a>';
                html += '       </div>';
                html += '   </div>';
                html += '</div>';


                //$("#blog-items").append(html);

                var cascadeHTML = jQuery(html);

                //$kbGrid.masonry
                $kbGrid.prepend( cascadeHTML ).masonry( 'prepended', cascadeHTML );
                //$('#blog-items').masonry('prepended', cascadeHTML);
                $('#blog-items').masonry('reloadItems');
                $('#blog-items').masonry('layout');

            }, error: function (data) {
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalAddArticle .loading").addClass('hidden');

                $("#btnSaveNewArticle").removeClass('hidden');
            }
        });





    });


    /** Open Edit Article Modal */
    $("#blogs").on('click', '.btn-edit-article',function (){
        var blogId = $(this).attr('data-id');

        $.ajax({
            type: "post",
            url: baseURL + '/kb/ajax/get/' + blogId,
            data: {
                "_token": csrfToken,
                "id": blogId
            },
            success: function(data) {
                var options =  {
                    height: 300,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert',['ltr','rtl', 'link']],
                        ['view', ['codeview']],
                        ['picture',['picture']]
                    ],
                    callbacks : {
                        onImageUpload: function(image) {
                            uploadImageToArticleDesc(image[0]);
                        },
                        onMediaDelete: function($target, editor, $editable) {
                            $target.remove();
                        }
                    }
                };


                $("#btnEditArticle").attr('data-id', blogId);

                $("#article-edit-desc").summernote(options);
                $("#article-edit-desc").summernote('code', data['html_desc']);
                $("#article-edit-title").val(data['title']);
                $("#article-edit-slug").val(data['slug']);
                $("#article-edit-summary").val(data['summary']);
                if (data['enabled'] == 1) {
                    $('#article-edit-enabled').iCheck('check');
                } else {
                    $('#article-edit-enabled').iCheck('uncheck');
                }


                $('#article-edit-tags').tagsinput('removeAll');


                $("#btnEditArticle").removeClass('hidden');
                $("#modalEditArticle .loading").addClass('hidden');
                $("#modalEditArticle .error").addClass('hidden');
                $("#modalEditArticle .error ul").empty();

                var tags = data['tags'];
                for (var k=0; k < tags.length; k++) {
                    $('#article-edit-tags').tagsinput('add', tags[k]);
                }

                modalEditKb.modal({
                    backdrop: 'static',
                    height: 600,
                    keyboard: false
                });
            }, error:function(data) {

            }
        });
    });



    /** Edit Article */
    $("#btnEditArticle").click(function () {
        $("#btnEditArticle").addClass('hidden');
        $("#modalEditArticle .loading").removeClass('hidden');
        $("#modalEditArticle .error ul").empty();



        var ar_name = $("#article-edit-title").val();
        var ar_slug = $("#article-edit-slug").val();
        var ar_summary = $("#article-edit-summary").val();
        var ar_desc = $("#article-edit-desc").val();
        var ar_tags = $("#article-edit-tags").val();
        var ar_enabled = $("#article-edit-enabled").attr('data-checked');
        var blogId = $("#btnEditArticle").attr('data-id');
        if (ar_enabled != 'null'){
            ar_enabled = 1;
        } else {
            ar_enabled = 2;
        }


        var postData = {
            "_token": csrfToken,
            "id": blogId,
            "title" : ar_name,
            "slug" : ar_slug,
            "summary" : ar_summary,
            "enabled" : ar_enabled,
            "html_desc" : ar_desc,
            "tags": ar_tags
        };


        $.ajax({
            type: "post",
            url: baseURL + '/kb/ajax/update/' + blogId,
            data: postData,
            success: function (data) {
                modalEditKb.modal('hide');
                $(".error").addClass('hidden');
                $("#btnEditArticle").removeClass('hidden');
                //AddStoredItemToTimeline("#edu-timeline", data, "#eduSection .loading", "edu");

                var blogId = data['id'];
                var blogTitle = data['title'];
                var blogImage = data['defaultImage'];
                var blogSlug = data['slug'];
                var blogUrl = data['url'];
                var blogBaseUrl = data['baseURL'];
                var blogDate = data['date'];
                var blogReadMore = data['readMore'];
                var blogBody = data['html_desc'];
                var blogEnabled = data['enabled'];
                var blogSummary = data['summary'];
                var blogTags = data['tags'];


                var blogDiv = 'article-' + blogId;


                $('#' + blogDiv + ' .article-img a').attr('href', blogUrl);
                $('#' + blogDiv + ' .article-img a').attr('title', blogTitle);


                var htmlTitle = '           <a href="'+blogUrl+'" title="'+blogTitle+'">';
                htmlTitle += '               <i class="fa fa-newspaper-o"></i>' + blogTitle;
                htmlTitle += '           </a>';
                $("#"+blogDiv + ' h2').attr('title', blogTitle);
                $("#"+blogDiv + ' h2').html(htmlTitle);

                $("#"+blogDiv + ' .article-date-time .time').html('<li class="time"><i class="fa fa-calendar"></i>'+blogDate+'</li>');

                var htmlHref = '           <a href="'+blogUrl+'" title="'+blogTitle+'">';
                htmlHref += '               ' + blogReadMore;
                htmlHref += '           </a>';

                $("#"+blogDiv + ' .article-body').html(blogSummary + htmlHref);


                $("#"+blogDiv + ' .article-tags').html(' ');
                if (blogTags.length > 0 ) {
                    var htmlTag = '           <ul class="list-inline">';
                    for (var k=0; k < blogTags.length; k++){
                        htmlTag += '               <li>';
                        htmlTag += '                   <a href="'+baseURL+'/hashtag/'+blogTags[k]+'" title="'+blogTags[k]+'"';
                        htmlTag += '                       <i class="fa fa-hashtag"></i>';
                        htmlTag += '                       ' + blogTags[k];
                        htmlTag += '                   </a>';
                        htmlTag += '               </li>';
                    }
                    htmlTag += '           </ul>';
                    htmlTag += '       </div>';
                    $("#"+blogDiv + ' .article-tags').html(htmlTag);
                }


                if (blogEnabled == 1) {
                    $("#"+blogDiv + ' .btn-enabled-article').attr('data-enabled', '1');
                    $("#"+blogDiv + ' .btn-enabled-article').html('<i class="fa fa-eye-slash"></i>');
                } else {
                    $("#"+blogDiv + ' .btn-enabled-article').attr('data-enabled', '2');
                    $("#"+blogDiv + ' .btn-enabled-article').html('<i class="fa fa-eye"></i>');
                }



                $('#blog-items').masonry('reloadItems');
                $('#blog-items').masonry('layout');

            }, error: function (data) {
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditArticle .loading").addClass('hidden');

                $("#btnEditArticle").removeClass('hidden');
            }
        });





    });



    /**‌ Open Article Image Modal **/
    $("#blogs").on('click', '.btn-img-article',function () {
        var blogId = $(this).attr('data-id');
        var blogDiv = 'article-' + blogId;

        var imgSrc = $('#' + blogDiv + ' .article-img img').attr('src');
        if (imgSrc != '' && imgSrc != null){
            $("#btnDeleteArticleImage").removeClass('hidden');
        } else {
            $("#btnDeleteArticleImage").addClass('hidden');
        }
        $("#imgPrevArticle").attr('src', $('#' + blogDiv + ' .article-img img').attr('src'));
        $("#aPrevArticle").attr('href', $('#' + blogDiv + ' .article-img img').attr('src'));
        $('#progressBarArticle').html(" ");
        $('#progressBarArticle').width("0");

        $('#uploadArticleImage input[type=file]').attr('data-id', blogId);
        $("#btnDeleteArticleImage").attr('data-id', blogId);

        $("#modalEditArticleImage .error").addClass('hidden');

        modalUpdateArticleImage.modal({
            backdrop: 'static',
            keyboard: false
        });
        /** File Upload - Bio Image */
    });

    /** File Upload - Article Image */
    fileUploadArticleImage.change(function () {
        var fileInput = $(this);
        var blogId = $(this).attr('data-id');
        var urlToUpload = baseURL + "/image/ajax/set/article/"+blogId;
        var blogDiv = 'article-' + blogId;

        $("#modalEditArticleImage .loading").removeClass('hidden');

        $(this).simpleUpload(urlToUpload, {
            limit: 1,
            allowedExts: ["jpg", "jpeg", "jpe", "jif", "jfif", "jfi", "png", "gif"],
            allowedTypes: ["image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif", "image/x-gif"],
            maxFileSize: "{{ getMaxContentImageSize() }}",
            data: {
                '_token': csrfToken
            },
            start: function(file){
                //upload started
                $('#progressBarArticle').width(0);
                $('#progressBarArticle').html("");

                $(fileInput).attr('disabled', 'disabled');
            },
            progress: function(progress){
                //received progress
                $('#progressBarArticle').html(Math.round(progress) + "%");
                $('#progressBarArticle').width(progress + "%");
            },
            success: function(data){
                $('#imgPrevArticle').attr('src', data['image']);
                $('#aPrevArticle').attr('href', data['image']);
                $('#' + blogDiv + ' .article-img img').attr('src', data['image']);


                $('#' + blogDiv + ' .article-img img').on('load', function() {
                    $kbGrid.masonry();
                });




                $("#modalEditArticleImage .loading").addClass('hidden');
                modalUpdateArticleImage.modal('hide');



                this.upload.cancel();

            },
            error: function(error){
                //upload failed
                $("#modalEditArticleImage .loading").addClass('hidden');
                $('#progressBarArticle').html( + error.name + ": " + error.message);
            }
        });
    });

    /** Delete Article Image */
    $("#btnDeleteArticleImage").click(function () {
        var blogId = $(this).attr('data-id');
        var urlToDelete = baseURL + "/image/ajax/delete/article/"+blogId;
        var blogDiv = 'article-' + blogId;

        $("#modalEditArticleImage .loading").removeClass('hidden');

        $.ajax({
            type: "post",
            url: urlToDelete,
            data: {
                "_token": csrfToken,
                "id": blogId
            },
            success: function (data) {

                $('#imgPrevArticle').attr('src', data['path']);
                $('#aPrevArticle').attr('href', data['path']);
                $('#' + blogDiv + ' .article-img img').attr('src', data['path']);

                $('#' + blogDiv + ' .article-img img').on('load', function() {
                    $kbGrid.masonry();
                });

                $("#modalEditArticleImage .loading").addClass('hidden');

                modalUpdateArticleImage.modal('hide');

            }, error: function (data){
                var errors = data.responseJSON;
                $(".error").removeClass('hidden');
                $(".error ul").append("<li class='unknown-error'>" + unknown_error_2 + "</li>");
                $.each(errors, function (key, val) {
                    $(".error ul li.unknown-error").remove();
                    $(".error ul").append("<li>" + val + "</li>");
                });
                $("#modalEditArticleImage .loading").addClass('hidden');
            }
        });
    });


    /** Disable or Enable an Article */
    $("#blogs").on('click', '.btn-enabled-article',function () {

        var blogId = $(this).attr('data-id');
        var blogDiv = 'article-' + blogId;
        var blogEnabled = $(this).attr('data-enabled');
        var urlToPost = baseURL + '/kb/ajax/';

        $("#modalConfirm .loading").removeClass('hidden');
        $("#modalConfirm #btnYes").addClass('hidden');

        if (blogEnabled == '1'){
            urlToPost += 'disable';
        } else {
            urlToPost += 'enable';
        }
        urlToPost += '/' + blogId;

        $.ajax({
            type: "post",
            url: urlToPost,
            data: {
                "_token": csrfToken,
                "id": blogId
            },
            success: function (data) {

                if (blogEnabled == 1) {
                    $("#" + blogDiv + ' .btn-enabled-article').attr('data-enabled', '2');
                    $("#" + blogDiv + ' .btn-enabled-article').html('<i class="fa fa-eye"></i>');
                } else {
                    $("#" + blogDiv + ' .btn-enabled-article').attr('data-enabled', '1');
                    $("#" + blogDiv + ' .btn-enabled-article').html('<i class="fa fa-eye-slash"></i>');
                }

            }, error: function (data) {
                //
            }
        });
    });

    /** Delete Article */
    $("#blogs").on('click', '.btn-delete-article',function () {
        var blogId = $(this).attr('data-id');
        var blogDiv = 'article-' + blogId;
        //var urlToPost = baseURL + '/kb/ajax/delete/' + blogId;

        $("#modalConfirm .modal-desc").html(msgDeleteArticle);
        $("#modalConfirm #btnYes").removeClass('hidden');
        $("#modalConfirm #btnYes").attr('data-id', blogId);
        $("#modalConfirm #btnNo").html(btnNo);
        $("#modalConfirm .loading").addClass('hidden');

        $('#modalConfirm').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Confirm Delete Article */
    $("#btnYes").click(function() {
        var blogId = $(this).attr('data-id');
        var blogDiv = 'article-' + blogId;
        var urlToPost = baseURL + '/kb/ajax/delete/' + blogId;
        $("#modalConfirm .loading").removeClass('hidden');
        $("#modalConfirm #btnYes").addClass('hidden');

        $.ajax({
            type: "post",
            url: urlToPost,
            data: {
                "_token": csrfToken,
                "id": blogId
            },
            success: function (data) {
                $("#modalConfirm .loading").addClass('hidden');
                $("#modalConfirm").modal('hide');
                $element = $("#" + blogDiv);
                $kbGrid.masonry('remove', $element );

                $("#" + blogDiv).remove();
                $kbGrid.masonry();

            }, error: function(data) {
                $("#modalConfirm .modal-desc").html(unknown_error_3);
                $("#modalConfirm #btnYes").addClass('hidden');
                $("#modalConfirm #btnNo").html(btnClose);
                $("#modalConfirm .loading").addClass('hidden');
            }
        });
    });


    /** Open Comments Modal */
    $("#blogs").on('click', '.btn-comment-article',function () {
        var blogId = $(this).attr('data-id');
        var blogDiv = 'article-' + blogId;

        $("#modalComments").attr('data-blog-id', blogId);


        if ( $.fn.dataTable.isDataTable( '#articleCommentsTable' ) ) {
            articleCommentsTable.destroy();
        }
        articleCommentsTable = $('#articleCommentsTable').DataTable({
            "oLanguage": {
                "sEmptyTable": dt_empty,
                "sInfo": dt_info,
                "sInfoEmpty": dt_info_empty,
                "sInfoFiltered": dt_filter,
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": dt_menu_record,
                "sLoadingRecords": dt_loading,
                "sProcessing": dt_processing,
                "sSearch": dt_search,
                "sZeroRecords": dt_zero_record,
                "oPaginate": {
                    "sFirst": dt_first,
                    "sLast": dt_last,
                    "sNext": dt_next,
                    "sPrevious": dt_prev
                },
                "oAria": {
                    "sSortAscending": dt_sort_asc,
                    "sSortDescending": dt_sort_desc
                }
            },
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": baseURL + '/comment/kb/' + blogId,
            "columns": [

                {"data": "created_at", "class": "cls-date"},
                {"data": "name", "class": "cls-name"},
                {"data": "email", "class": "cls-email"},
                {"data": "comments", "class": "cls-comment"},
                {"data": "status", "class": "cls-status"},
                {"data": "operation", "class": "cls-operation"}
            ],
            "createdRow": function (row, data, rowIndex) {

            }
        });


        $("#modalComments").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Delete Comment */
    $('#articleCommentsTable tbody').on('click', 'a.btn-delete', function () {
        var row = $($(this).closest('td').parent()[0]);
        row.addClass('selected');
        var commentId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#loading-' + commentId);



        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/comment/delete/' + commentId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': commentId
            },
            success: function(data) {
                articleCommentsTable.row('.selected').remove().draw( false );
            },
            error: function (error) {
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });

    });


    /** Hide Comment */
    $('#articleCommentsTable tbody').on('click', 'a.btn-hide', function () {
        var row = $($(this).closest('td').parent()[0]);
        var commentId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#loading-' + commentId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/comment/hide/' + commentId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': commentId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-check"></i>&nbsp;&nbsp;' + txt_approve);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-warning');
                thisButton.addClass('btn-success');

                thisButton.removeClass('btn-hide');
                thisButton.addClass('btn-approve');

                $("#status-" + commentId).html(txt_not_approved);
                $("#status-" + commentId).removeClass("text-success");
                $("#status-" + commentId).addClass("text-warning");

                thisLoading.addClass('hidden');
            },
            error: function (error) {
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });

    /** Approve Comment */
    $('#articleCommentsTable tbody').on('click', 'a.btn-approve', function () {
        var row = $($(this).closest('td').parent()[0]);

        var commentId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#loading-' + commentId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/comment/approve/' + commentId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': commentId
            },
            success: function(data) {


                thisButton.html('<i class="fa fa-close"></i>&nbsp;&nbsp;' + txt_hide);
                thisButton.removeClass('hidden');
                thisButton.addClass('btn-warning');
                thisButton.removeClass('btn-success');

                thisButton.removeClass('btn-approve');
                thisButton.addClass('btn-hide');

                $("#unread-status-" + commentId).remove();
                $("#status-" + commentId).html(txt_approved);
                $("#status-" + commentId).removeClass("text-warning");
                $("#status-" + commentId).addClass("text-success");

                thisLoading.addClass('hidden');


                updateUnreadComments(); // Update Unread Notification
                commentsNotoficationCount--;

            },
            error: function (error) {
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });



    if(typeof ArticlePage != 'undefined') {
        $(window).scroll(function() { //detect page scroll
            if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
                ArticlePage++;
                loadMoreArticleOnPageScroll(ArticlePage);
                //alert(ArticlePage);
            }
        });
    }



    /** Article Try Again */
    $("#btnArticleTryAgain").click(function () {
        $("#kbLoading .error").addClass('hidden');
        $("#kbLoading .text-info").removeClass('hidden');
        loadMoreArticleOnPageScroll(ArticlePage++);
    });


    /** Load More Article **/
    function loadMoreArticleOnPageScroll(page){
       $.ajax(
           {
               url: baseURL + '/kb/ajax/load/more?page=' + page,
               type: 'get',
               //dataType: 'html',
               beforSend: function(){
                   $("#kbLoading").removeClass('hidden');
                   $("#kbLoading .error").addClass('hidden');
                   $("#kbLoading .text-info").removeClass('hidden');
               }
           })
           .done(function (data){

               if (data['length'] > 0) {
                   for (var k=0; k < data['articles'].length; k++){

                       html = data['articles'][k];
                       //$("#blog-items").append(html);
                       var cascadeHTML = jQuery(html);

                       $kbGrid.append( cascadeHTML ).masonry( 'appended', cascadeHTML );
                       //$('#blog-items').masonry('prepended', cascadeHTML);
                       $('#blog-items').masonry('reloadItems');
                       $('#blog-items').masonry('layout');

                       $('#article' + data['ids'][k] + ' .article-img img').on('load', function() {
                           $kbGrid.masonry();
                       });

                   }
               } else {
                   $("#kbLoading").addClass('hidden');
               }

               $("#kbLoading").addClass('hidden');

           })
           .fail(function(jqXHR, ajaxOptions, thrownError){
               ArticlePage--;
               $("#kbLoading .text-info").addClass('hidden');
               $("#kbLoading .error").removeClass('hidden');
           });
    }


    /** Load Unread Comments */
    $("#not-comments").on('click', '#btnUnreadComments',function () {

        if ( $.fn.dataTable.isDataTable( '#articleCommentsTable' ) ) {
            articleCommentsTable.destroy();
        }
        articleCommentsTable = $('#articleCommentsTable').DataTable({
            "oLanguage": {
                "sEmptyTable": dt_empty,
                "sInfo": dt_info,
                "sInfoEmpty": dt_info_empty,
                "sInfoFiltered": dt_filter,
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": dt_menu_record,
                "sLoadingRecords": dt_loading,
                "sProcessing": dt_processing,
                "sSearch": dt_search,
                "sZeroRecords": dt_zero_record,
                "oPaginate": {
                    "sFirst": dt_first,
                    "sLast": dt_last,
                    "sNext": dt_next,
                    "sPrevious": dt_prev
                },
                "oAria": {
                    "sSortAscending": dt_sort_asc,
                    "sSortDescending": dt_sort_desc
                }
            },
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": baseURL + '/comment/unread/',
            "columns": [

                {"data": "created_at", "class": "cls-date"},
                {"data": "name", "class": "cls-name"},

                {"data": "email", "class": "cls-email"},
                {"data": "comments", "class": "cls-comment"},
                {"data": "status", "class": "cls-status"},
                {"data": "operation", "class": "cls-operation"}
            ],
            "createdRow": function (row, data, rowIndex) {

            }
        });


        $("#modalComments").modal({
            backdrop: 'static',
            keyboard: false
        });
    });






    /**
     *
     *
     *
     *  E N D Article
     *
     *
     */





    /**
     *
     *
     * Begin Language
     *
     *
     *
     */

    /** Open Language Management Modal */
    $("#btnManageLang").click(function () {

        if ( $.fn.dataTable.isDataTable( '#langsTable' ) ) {
            manageLangsTable.destroy();
        }
        manageLangsTable = $('#langsTable').DataTable({
            "oLanguage": {
                "sEmptyTable": dt_empty,
                "sInfo": dt_info,
                "sInfoEmpty": dt_info_empty,
                "sInfoFiltered": dt_filter,
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": dt_menu_record,
                "sLoadingRecords": dt_loading,
                "sProcessing": dt_processing,
                "sSearch": dt_search,
                "sZeroRecords": dt_zero_record,
                "oPaginate": {
                    "sFirst": dt_first,
                    "sLast": dt_last,
                    "sNext": dt_next,
                    "sPrevious": dt_prev
                },
                "oAria": {
                    "sSortAscending": dt_sort_asc,
                    "sSortDescending": dt_sort_desc
                }
            },
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": baseURL + '/language/get',
            "columns": [

                {"data": "name", "class": "cls-lang-name"},
                {"data": "short", "class": "cls-lang-short"},
                {"data": "enabled", "class": "cls-lang-enable"},
                {"data": "is_rtl", "class": "cls-lang-dir"},
                {"data": "operation", "class": "cls-lang-operation"}
            ],
            "createdRow": function (row, data, rowIndex) {

            }
        });


        $("#modalLanguages").modal({
            backdrop: 'static',
            keyboard: false
        });
    });


    /** Enable Language **/
    $('#langsTable tbody').on('click', 'a.btn-lang-en', function () {
        var row = $($(this).closest('td').parent()[0]);
        var langId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#lang-loading-' + langId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/language/enable/' + langId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': langId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-close"></i>&nbsp;&nbsp;' + txt_disable);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-success');
                thisButton.addClass('btn-warning');

                thisButton.removeClass('btn-lang-en');
                thisButton.addClass('btn-lang-di');

                $("#lang-status-" + langId).html(txt_active);
                $("#lang-status-" + langId).removeClass("text-success");
                $("#lang-status-" + langId).addClass("text-warning");

                thisLoading.addClass('hidden');
            },
            error: function (error) {
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });

    /** Disable Language **/
    $('#langsTable tbody').on('click', 'a.btn-lang-di', function () {
        var row = $($(this).closest('td').parent()[0]);
        var langId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#lang-loading-' + langId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/language/disable/' + langId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': langId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-check"></i>&nbsp;&nbsp;' + txt_enable);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-warning');
                thisButton.addClass('btn-success');

                thisButton.removeClass('btn-lang-di');
                thisButton.addClass('btn-lang-en');

                $("#lang-status-" + langId).html(txt_inactive);
                $("#lang-status-" + langId).removeClass("text-warning");
                $("#lang-status-" + langId).addClass("text-success");

                thisLoading.addClass('hidden');
            },
            error: function (error) {

                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });



    /**
     *
     *
     * E N D Language
     *
     *
     *
     */


    /**
     *
     *
     * Begin Users
     *
     *
     *
     */



    /** Open User Management Modal */
    $("#btnManageUsers").click(function () {
        $("#user-modal-error .error").addClass('hidden');
        if ( $.fn.dataTable.isDataTable( '#usersTable' ) ) {
            manageUsersTable.destroy();
        }
        manageUsersTable = $('#usersTable').DataTable({
            "oLanguage": {
                "sEmptyTable": dt_empty,
                "sInfo": dt_info,
                "sInfoEmpty": dt_info_empty,
                "sInfoFiltered": dt_filter,
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": dt_menu_record,
                "sLoadingRecords": dt_loading,
                "sProcessing": dt_processing,
                "sSearch": dt_search,
                "sZeroRecords": dt_zero_record,
                "oPaginate": {
                    "sFirst": dt_first,
                    "sLast": dt_last,
                    "sNext": dt_next,
                    "sPrevious": dt_prev
                },
                "oAria": {
                    "sSortAscending": dt_sort_asc,
                    "sSortDescending": dt_sort_desc
                }
            },
            "pageLength": 5,
            "processing": true,
            "serverSide": true,
            "ajax": baseURL + '/user/get',
            "columns": [
                {"data": "name", "class": "cls-user-name"},
                {"data": "email", "class": "cls-user-email"},
                {"data": "enabled", "class": "cls-enabled-enable"},
                {"data": "is_admin", "class": "cls-enabled-status"},
                {"data": "operation", "class": "cls-user-operation"}
            ],
            "createdRow": function (row, data, rowIndex) {

            }
        });


        $("#modalUsers").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    /** Enable User **/
    $('#usersTable tbody').on('click', 'a.btn-user-en', function () {
        $("#user-modal-error .error").addClass('hidden');
        var row = $($(this).closest('td').parent()[0]);
        var userId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#user-loading-' + userId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/user/enable/' + userId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': userId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-close"></i>&nbsp;&nbsp;' + txt_disable);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-success');
                thisButton.addClass('btn-warning');

                thisButton.removeClass('btn-user-en');
                thisButton.addClass('btn-user-di');

                $("#user-status-" + userId).html(txt_active);
                $("#user-status-" + userId).removeClass("text-warning");
                $("#user-status-" + userId).addClass("text-success");

                thisLoading.addClass('hidden');
            },
            error: function (data) {
                var json_response = data.responseJSON;
                $("#user-modal-error .error").removeClass('hidden');
                if (json_response.error == true) {
                    var html = '<li>' + json_response.msg + '</li>';
                    $(".error ul").html(html);

                }
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });

    /** Disable User */
    $('#usersTable tbody').on('click', 'a.btn-user-di', function () {
        $("#user-modal-error .error").addClass('hidden');
        var row = $($(this).closest('td').parent()[0]);
        var userId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#user-loading-' + userId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/user/disable/' + userId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': userId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-check"></i>&nbsp;&nbsp;' + txt_enable);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-warning');
                thisButton.addClass('btn-success');

                thisButton.removeClass('btn-user-di');
                thisButton.addClass('btn-user-en');

                $("#user-status-" + userId).html(txt_inactive);
                $("#user-status-" + userId).removeClass("text-success");
                $("#user-status-" + userId).addClass("text-warning");

                thisLoading.addClass('hidden');
            },
            error: function (data) {
                var json_response = data.responseJSON;
                $("#user-modal-error .error").removeClass('hidden');
                if (json_response.error == true) {
                    var html = '<li>' + json_response.msg + '</li>';
                    $(".error ul").html(html);

                }
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });



    /** Define As Admin User **/
    $('#usersTable tbody').on('click', 'a.btn-user-admin', function () {
        $("#user-modal-error .error").addClass('hidden');
        var row = $($(this).closest('td').parent()[0]);
        var userId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#user-loading-' + userId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/user/define/admin/' + userId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': userId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-close"></i>&nbsp;&nbsp;' + txt_as_user);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-danger');
                thisButton.addClass('btn-info');

                thisButton.removeClass('btn-user-admin');
                thisButton.addClass('btn-user-normal');

                $("#is-admin-" + userId).html(data['stat']);
                $("#is-admin-" + userId).removeClass("label-info");
                $("#is-admin-" + userId).addClass("label-success");

                thisLoading.addClass('hidden');
            },
            error: function (data) {
                var json_response = data.responseJSON;
                $("#user-modal-error .error").removeClass('hidden');
                if (json_response.error == true) {
                    var html = '<li>' + json_response.msg + '</li>';
                    $(".error ul").html(html);

                }
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });



    /** Define As Normal User **/
    $('#usersTable tbody').on('click', 'a.btn-user-normal', function () {
        $("#user-modal-error .error").addClass('hidden');
        var row = $($(this).closest('td').parent()[0]);
        var userId = $(this).attr('data-id');
        var thisButton = $(this);
        var thisLoading = $('#user-loading-' + userId);
        thisButton.addClass('hidden');
        thisLoading.removeClass('hidden');
        $.ajax({
            url: baseURL + '/user/define/normal/' + userId,
            type: "post",
            data:{
                '_token': csrfToken,
                'id': userId
            },
            success: function(data) {
                thisButton.html('<i class="fa fa-close"></i>&nbsp;&nbsp;' + txt_as_admin);
                thisButton.removeClass('hidden');
                thisButton.removeClass('btn-info');
                thisButton.addClass('btn-danger');

                thisButton.removeClass('btn-user-normal');
                thisButton.addClass('btn-user-admin');

                $("#is-admin-" + userId).html(data['stat']);
                $("#is-admin-" + userId).removeClass("label-success");
                $("#is-admin-" + userId).addClass("label-info");

                thisLoading.addClass('hidden');
            },
            error: function (data) {
                var json_response = data.responseJSON;
                $("#user-modal-error .error").removeClass('hidden');
                if (json_response.error == true) {
                    var html = '<li>' + json_response.msg + '</li>';
                     
                    $(".error ul").html(html);

                }
                thisButton.removeClass('hidden');
                thisLoading.addClass('hidden');
            }
        });
    });




    /**
     *
     *
     * E N D Users
     *
     *
     *
     */


    /**
     *
     * BEGIN Settings
     *
     *
     */


    var sideSettingLoading = function ($loadingStat, $btnTextId, $icon) {
        if ($loadingStat == 'show') {
            $($btnTextId + " .menu-icon").removeClass($icon);
            $($btnTextId + " .loading").removeClass('hidden');
        } else {
            $($btnTextId + " .menu-icon").addClass($icon);
            $($btnTextId + " .loading").addClass('hidden')
        }
    };

    /** Enable / Disable Bio */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiBio', function () {
        var btnId = "#btnEnDiBio";
        var btnIcon = "fa-question-circle";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/bio';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/bio';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });

    /** Enable / Disable Project */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiProject', function () {
        var btnId = "#btnEnDiProject";
        var btnIcon = "fa-cubes";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/project';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/project';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });

    /** Enable / Disable Skill */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiSkill', function () {
        var btnId = "#btnEnDiSkill";
        var btnIcon = "fa-check-square";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/skill';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/skill';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });

    /** Enable / Disable Experience */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiEdu', function () {
        var btnId = "#btnEnDiEdu";
        var btnIcon = "fa-mortar-board";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/experience';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/experience';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });

    /** Enable / Disable Contact */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiContact', function () {
        var btnId = "#btnEnDiContact";
        var btnIcon = "fa-share-alt-square";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/contact';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/contact';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });

    /** Enable / Disable Kb */
    $("#control-sidebar-home-tab").on('click', '#btnEnDiKb', function () {
        var btnId = "#btnEnDiKb";
        var btnIcon = "fa-newspaper-o";
        var status = parseInt($(this).attr('data'));
        var classToRemove = '';
        var classToAdd = '';
        var statToChange = 0;
        var urlToSend = '';

        sideSettingLoading('show', btnId, btnIcon);

        if (status == 1) {
            urlToSend = baseURL + '/setting/disable/kb';
            classToRemove = 'bg-red';
            classToAdd = 'bg-gray';
            statToChange = 2;
        } else {
            urlToSend = baseURL + '/setting/enable/kb';
            classToRemove = 'bg-gray';
            classToAdd = 'bg-red';
            statToChange = 1;
        }

        $.ajax({
            url: urlToSend,
            type: 'post',
            data: {
                '_token': csrfToken
            }, success: function(data) {
                sideSettingLoading('hide', btnId, btnIcon);
                $(btnId + " .menu-icon").removeClass(classToRemove);
                $(btnId + " .menu-icon").addClass(classToAdd);
                $(btnId + " .menu-info p").html(data['menu-title']);
                $(btnId).attr('data', statToChange);
            }, error: function() {
                sideSettingLoading('hide', btnId, btnIcon);
            }

        });
    });


    /** Save Web Info */
    $("#btnSaveWebInfo").click(function(){
        var webTitle = $("#web-info-title").val();
        var webKeywords = $("#web-info-keywords").val();
        var webDesc = $("#web-info-desc").val();
        var webLong = $("#web-menu-long").val();
        var webShort = $("#web-menu-short").val();

        $("#btnSaveWebInfo .loading").removeClass('hidden');
        $("#web-info-status").html(' ');
        $(this).addClass('disabled');
        $.ajax({
            type: 'post',
            url: baseURL + '/setting/web/info',
            data: {
                '_token': csrfToken,
                'title': webTitle,
                'keywords': webKeywords,
                'description': webDesc,
                'menu_long_title': webLong,
                'menu_short_title': webShort,
            }, success: function(data) {
                $("#web-info-status").removeClass('text-danger');
                $("#web-info-status").addClass('text-info');
                $("#web-info-status").html(data['msg']);
                $("#btnSaveWebInfo").removeClass('disabled');
                $("#btnSaveWebInfo .loading").addClass('hidden');

                $("#header-logo-mini").html(webShort);
                $("#header-logo-lg").html(webLong);

            }, error: function(data) {
                $("#web-info-status").html(unknown_error_2);
                $("#web-info-status").removeClass('text-info');
                $("#web-info-status").addClass('text-danger');
                $("#btnSaveWebInfo").removeClass('disabled');
                $("#btnSaveWebInfo .loading").addClass('hidden');

            }
        })
    });

    /** Save Customization */
    $("#btnSaveWebCustomization").click(function(){
        var webCss = $("#web-custom-css").val();
        var webJs = $("#web-custom-js").val();
        var webGoogle = $("#web-google-analytics").val();


        $("#btnSaveWebCustomization .loading").removeClass('hidden');
        $("#web-custom-status").html(' ');
        $(this).addClass('disabled');
        $.ajax({
            type: 'post',
            url: baseURL + '/setting/web/custom',
            data: {
                '_token': csrfToken,
                'custom_css': webCss,
                'custom_js': webJs,
                'google_analytics': webGoogle,
            }, success: function(data) {
                $("#web-custom-status").removeClass('text-danger');
                $("#web-custom-status").addClass('text-info');
                $("#web-custom-status").html(data['msg']);
                $("#btnSaveWebCustomization").removeClass('disabled');
                $("#btnSaveWebCustomization .loading").addClass('hidden');

            }, error: function(data) {
                $("#web-custom-status").html(unknown_error_2);
                $("#web-custom-status").removeClass('text-info');
                $("#web-custom-status").addClass('text-danger');
                $("#btnSaveWebCustomization").removeClass('disabled');
                $("#btnSaveWebCustomization .loading").addClass('hidden');

            }
        })
    });




    /**
     *
     * E N D Settings
     *
     *
     */


});

