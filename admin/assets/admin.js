"use strict";

(function($) {
  $(document).ready(function() {

    var failed = [];
    var passed =[];


    $('.get-all').change( function(e){
      if(this.checked) {
        $(this).closest('.fetch-data').find('.id-specific-section').hide();
        $(this).closest('.fetch-data').find('.id-specific-section ul input:checkbox').each(function (index, value){
          $(value).prop('checked', true);
        })
      }else{
        $(this).closest('.fetch-data').find('.id-specific-section').show();
        $(this).closest('.fetch-data').find('.id-specific-section ul input:checkbox').each(function (index, value){
          $(value).prop('checked', false);
        })
      }
    });

    /**
     * make Ajax call
     * @value POST ID
     */
    function makeAjaxCall(mainURL, filestructures, homeurl, subfoldername){
      $.ajax({
        type: 'POST',
        url: ajax.ajaxurl,
        data: {
          'action' : "build_page",
          'mainurl' : mainURL,
          'filestructures' : filestructures,
          'homeurl' : homeurl,
          'subfoldername' : subfoldername
        },
        success: function(response){
          // if(response === 'null'){
          //   failed.push(postID);
          // }else{
          //   passed.push(postID);
          //   // passed[postID] = response;
          // }
          console.log(response);
          // $('.report .items-finished').append('<li>' + postID + ' ended copying as ' + response + ' </li>');
        },
        async:false
      });
    }
    // Make ajax requests

    $('#server_static_builder').submit(function (e){
      e.preventDefault();
      
      const allURLS =  $.parseJSON($('input[name="allurl"]').val());
      const filestructures = $('input[name="filestructures"]').val();
      const homeurl =  $('input[name="homeurl"]').val();
      const subfoldername =  $('input[name="subfoldername"]').val();
      const sleep = (ms) => {
        return new Promise((resolve) => setTimeout(resolve, ms));
      };
      const getNumFruit = (mainURL, filestructures, homeurl, subfoldername) => {
        return sleep(1000).then((v) => {
          // $('.report .items-started').append('<li>' + $(post).val() + ' started to copying</li>');
          makeAjaxCall(mainURL, filestructures, homeurl, subfoldername );
        });
      };
      const forLoop = async (_) => {
        // $(".report").show();
        // $('.report .status').text("Please do not close the browser tab, posts are started to copying");
        // $('.report .loading').show();
        for (let index = 0; index < allURLS.length; index++) {
          const mainURL = allURLS[index];
          await getNumFruit(mainURL, filestructures, homeurl, subfoldername);
          // const numFruit = await getNumFruit(post);
          // console.log(numFruit);
        }
        // $('.report .status-ends').text("All task is finished you can close the tab now");
        // $('.report .loading').hide();
        // $(".report").hide();
        // console.log("Passed: ", passed, "Failed: ", failed);
        $('form').append("<div class='sucess' style='color: green; font-size:'60px'; text-align:'center'; '>Done</div>");
      };
      forLoop();
      


    });
  })
})(jQuery);