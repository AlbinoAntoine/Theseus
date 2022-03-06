jQuery(document).ready(function($) {
    var audioValidation = new Audio(baseUrl+'/assets/sound/sound_validation.mp3');
    var myOffcanvas = document.getElementById('offcanvasPrimary')
    var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)

    $('.btn-menu').click(function () {
        bsOffcanvas.toggle()
    });

    $('.select-task').click(function (){
        selectTask($(this))
    });

    function selectTask(select_task){
        const taskSelected = select_task.parent('.task');
        if (!taskSelected.hasClass('task-selected')) {
            $('.task-selected').removeClass('task-selected')
            taskSelected.addClass('task-selected')
            var task_id = taskSelected.attr('id');
            var data = {'task_id': task_id}
            $.ajax({
                type: "POST",
                url: siteUrl + '/action/task_detail',
                data: data,
            }).done(function (response) {
                var detailElement = $('.detail-task');
                if (detailElement.hasClass('show')) {
                    $('#container-detail-task').html(response)
                } else {
                    $('#container-detail-task').html(response)
                    detailElement.animate({
                        width: "600px",
                    }).fadeIn('slow').addClass('show');
                }
                $('.btnDeleteTask').click(function(){
                    deleteTask($(this))
                })
            });
        }else{
            $('.detail-task').hide().removeClass('show');
            taskSelected.removeClass('task-selected');
        }
    }

    $('#close-detail-task').click(function () {
        $('.detail-task').hide().removeClass('show');
        $('.task-selected').removeClass('task-selected');
    });

    $('#add-task').submit(function (event){
        event.preventDefault()
        var champ = $('.add-task')
        if (champ.val()){

            var form_url = $(this).attr("action"); //récupérer l'URL du formulaire
            var form_method = $(this).attr("method"); //récupérer la méthode GET/POST du formulaire
            var form_data = $(this).serialize(); //Encoder les éléments du formulaire pour la soumission
            champ.val('');

            $.ajax({
                url : form_url,
                type: form_method,
                data : form_data
            }).done(function(response){
                $('#task-toDo').prepend(response);
                $('.validate-task').off("change").on( "change", function () {
                    validerTask($(this))
                });
                $('.select-task').off('click').click(function (){
                    selectTask($(this));
                });
                recalcProgress($('#idStep').val());
            });
        }
    })

    $('.validate-task').on( "change", function () {
        validerTask($(this))
    });
    function validerTask(taskCheckbox){
        var check;
        if ($(taskCheckbox).is(':checked')) {
            check = 1;
        } else {
            check = 0;
        }
        var idTask = taskCheckbox.parents().attr('id');
        var form_url = siteUrl+'/action/check_task'
        $.ajax({
            url : form_url,
            type: 'post',
            data : {'id':idTask, 'checked': check }
        }).done(function(){
            const compteur = $('#countTask');
            var nbrTask;
            if (check === 1){
                $('#task-Finished').append($('#'+idTask));
                compteur.html(parseInt(compteur.html())+1);
                $('.finishedTilte').show();
                audioValidation.play();
            }else{
                $('#task-toDo').append($('#'+idTask));
                nbrTask = parseInt(compteur.html())-1
                compteur.html(nbrTask);
                if (nbrTask <= 0){
                    $('.finishedTilte').hide();
                }
            }
            recalcProgress($('#idStep').val());
        });
    }

    $('#modifTask').submit(function(event){
        event.preventDefault();
        saveTask($(this));
    })

    function saveTask(form){
        var form_url = siteUrl+'/action/save_task'
        var formulaire = form;
        var form_method = formulaire.attr("method"); //récupérer la méthode GET/POST du formulaire
        var form_data = formulaire.serialize(); //Encoder les éléments du formulaire pour la soumission
        $.ajax({
            url : form_url,
            type: form_method,
            data : form_data
        }).done(function(response){
            if (response === 'true'){
                messageUser('Task updated', 'success');
                recalcProgress($('#idStep').val());
                $('.task-selected>.select-task').html(form_data['title'])
                location.reload()
            }else {
                messageUser('An error occurred while updating the task', 'error');
            }
        });
    }
    function messageUser(message, type){
        var alert_type = 'alert-danger';
        if (type === 'success'){
            alert_type = 'alert-success';
        }
        $('body').append('<div class="alert '+alert_type+' alert-ajax" style="display: none">'+message+'</div>');
        $('.alert-ajax').show('fast');
        setTimeout(function(){
            $('.alert-ajax').hide('fast');
            }, 3000);
    }

    function recalcProgress(id_step){
        $.ajax({
            url : siteUrl+'/action/update_progress',
            type: 'post',
            data : {'id_step' : id_step}
        }).done(function(response){
            $('#progress').css({'width' : response});
            $('#val-progress').html(response);
        });
    }

    $('.form-member').submit(function (event){
        event.preventDefault();
        var form_url = siteUrl+'/action/update_member'
        var formulaire = $(this);
        var form_data = formulaire.serialize(); //Encoder les éléments du formulaire pour la soumission
        $.ajax({
            url : form_url,
            type: 'post',
            data : form_data
        }).done(function(response){
            if (response === 'true'){
                messageUser('Member updated', 'success');
            }else {
                messageUser('An error occurred while updating the member', 'error');
            }
        });
    })



    var valTitleStep;
    var inputTitleStep = $("#title-step");
    inputTitleStep.focus(function(){
        valTitleStep = $('#title-step').val().trim();
    });
    inputTitleStep.blur(function(){
        updateStep();
    });
    $('#update-title-step').submit(function (event){
        event.preventDefault();
        updateStep();
    })
    function updateStep(){
        var newtitle = $('#title-step').val().trim();
        if (valTitleStep !== newtitle){
            var form_url = siteUrl+'/action/update_step_title'

            $.ajax({
                url : form_url,
                type: 'post',
                data : {'idStep':$('#idStep').val(),'title':newtitle}
            }).done(function(response){
                if (response === 'true'){
                    messageUser('Title updated', 'success');
                }else {
                    messageUser('An error occurred while updating the title', 'error');
                }
            });
        }
    }

    $('#createProject').click(function (){
        $.ajax({
            url : siteUrl+'/action/modal_create_project',
        }).done(function(response){
            $('body').append(response);
            var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'), {
                keyboard: false
            })
            myModal.show()
        });
    })
    $('.modifyProject').click(function (){
        var id_project = $(this).parents('.card').attr('id');
        $.ajax({
            url : siteUrl+'/action/modal_modify_project/'+id_project,
        }).done(function(response){
            $('body').append(response);
            var myModal = new bootstrap.Modal(document.getElementById('updateProject'), {
                keyboard: false
            })
            myModal.show()
        });
    });

    $('.deleteProject').click(function (event) {
        if(!window.confirm('Are you sure you want to delete this project ?')){
            event.preventDefault();
        }
    });


    function deleteTask(element){
        var id_task = element.parents('.detail-content').attr('data-task-id');
        $.ajax({
            url : siteUrl+'/action/modal_delete_task/'+id_task,
            data : {'url':document.location.href},
            type:'post'
        }).done(function(response){
            $('body').append(response);
            var myModal = new bootstrap.Modal(document.getElementById('deleteTask'), {
                keyboard: false
            })
            myModal.show()
        });
    }
    $('#add_member').click(function (){
        var idProject = $(this).attr('data-idProject');
        $.ajax({
            url : siteUrl+'/action/modal_add_member/'+idProject,
        }).done(function(response){
            if($('#modal_addMember')){
                $('#modal_addMember').remove();
            }
            $('body').append(response);
            var myModal = new bootstrap.Modal(document.getElementById('modal_addMember'), {
                keyboard: false
            })
            var research = false;
            var timer;
            $('#searchUser').on("input", function (){
                var research = $(this).val().trim();
                if (research.length >= 2) {
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        var project = $('#idProject').val();
                        console.log('Project :'+project)
                        researchUser(research, project)
                    }, 800);
                }
            });
            myModal.show()
        });
    });

    function researchUser(search, project){
        $.ajax({
            url : siteUrl+'/action/search_user',
            data : {'research': search, 'project': project },
            type:'post',
        }).done(function(response){
            $('#listSearchedUser').html(response);
            $('.addThisMember').off('click').click(function () {
                $(this).prop('disabled', true);
                addThisMember($(this).attr('id'));
            });
        });
    }

    function addThisMember(id_user){
        console.log('Ajout')
        var project = $('#idProject').val();
        $.ajax({
            url : siteUrl+'/action/add_member',
            data : {'id_user': id_user, 'project': project },
            type:'post',
        }).done(function(response){
            $('#infoReturn').html(response).show('fast');
        });
    }

    $('.RemoveThisMember').click(function (){
        var element = $(this).parents('.accordion-item');
        var idMember = $(this).attr('data-idMember');
        $.ajax({
            url : siteUrl+'/action/remove_member',
            data : {'idMember': idMember},
            type:'post',
        }).done(function(response){
            if (response === 'true'){
                messageUser('Member remove to this project', 'success');
                element.remove();
            }else {
                messageUser('An error occurred while removing this member', 'error');
            }
        });
    });
    $('#darkMode').click(function (){
        $('#formSettings').submit()
    })

});