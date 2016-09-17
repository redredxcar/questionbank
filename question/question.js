/**
 * Hold on all functions that manipulate questions
 */

function reloadQuestions(){
    $.ajax({
        url:'ajax/getQuestions.php',
        type:'get',
        dataType:'text',
        success:function(data, status){
            $(".question_content").html(data);
        },
        error:function(xhr){
            alert(xhr.responseText);
        }
    })
}

$(document).ready(function(){
    // reload the question table
    reloadQuestions();
    
    
    // submit the choice form
    $("#btnAddQuestion").on('click', function(){
        $("#choose_questiontype_form").submit();
    })
});

// get the question type that user choose and forward to create question page;
function choosequestiontype(){
    // get question type 
    var questiontype = $('input[name="questiontype"]:checked').val();
    $.ajax({
        url:'/multichoice/edit.php',
        type:'POST',
        data:{
            questiontype:questiontype
        },
        success:function(data, status){
            alert('success');
            // hide the modal
            $("#choose_questiontype_form").modal("hide");
            
        }
    })
}

/*// call choose function after submit modal
$("#choose_questiontype_form").validator().on('submit', function(e){
    if (e.isDefaultPrevented()){
        //
    }else{
        e.preventDefault();
        alert('pass, and forward');
        choosequestiontype();
    }
})*/

$('input[type=radio]').on('change', function(){
   
    if (!this.checked) return;
    
    var meid = $(this).attr('id');
    
    $('.summarycontent.'+meid).show();
    $('.summarycontent').not('div.' + meid).hide();
    
   
});


$('#btnChooseType').submit(function(){
    alert('submit button click');
    //$('#choose_questiontype_form').modal('hide');
    return false;
})