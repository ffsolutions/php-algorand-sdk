$(document).ready(function(){

      explorer = new Explorer();
      explorer.health();
      explorer.latest_transactions();
      explorer.latest_blocks();

      $("#search-buttom").click(function(){
          explorer.search();
      });

      $("#reload-buttom").click(function(){
          window.location.reload();
      });

});


class Explorer {

      url="php/controller.php";

      health() {
        $.post(this.url, {
              action: "health",
            }).done(function( data ) {
              $("#explorer_output").val(data);
        });
      }

      search() {
        if($("#keyword").val()==""){ //List
          switch ($("#type").val()) {
            case 'address':
                $.post(this.url, {
                    action: "addresses",
                    limit: $("#limit").val(),
                  }).done(function( data ) {
                    $("#right").css("display","");
                    $("#left").css("width","50%");
                    $("#right h2").html("Addresses");
                    $("#blocks").html(data);
                  });
              break;

              case 'block':
                  $.post(this.url, {
                      action: "blocks",
                      limit: $("#limit").val(),
                      minround: $("#minround").val(),
                    }).done(function( data ) {
                      $("#right").css("display","");
                      $("#left").css("width","50%");
                      $("#right h2").html("Blocks");
                      $("#blocks").html(data);
                    });
                break;

                case 'application':
                    $.post(this.url, {
                        action: "applications",
                        limit: $("#limit").val(),
                      }).done(function( data ) {
                        $("#right").css("display","");
                        $("#left").css("width","50%");
                        $("#right h2").html("Applications");
                        $("#blocks").html(data);
                      });
                  break;

                  case 'asset':
                      $.post(this.url, {
                          action: "assets",
                          limit: $("#limit").val(),
                        }).done(function( data ) {
                          $("#right").css("display","");
                          $("#left").css("width","50%");
                          $("#right h2").html("Assets");
                          $("#blocks").html(data);
                        });
                    break;

              default:
                $("#right").css("display","none");
                $("#left").css("width","100%");
          }
        }else{ //
          $.post(this.url, { //Search
                action: "search",
                limit: $("#limit").val(),
                type: $("#type").val(),
                keyword: $("#keyword").val(),
                minround: $("#minround").val(),
                maxround: $("#maxround").val(),
              }).done(function( data ) {
                $("#right").css("display","none");
                $("#left").css("width","100%");
                $("#results").html(data);
          });
        }

        this.transactions();

      }

      transactions() {
        $.post(this.url, {
              action: "transactions",
              limit: $("#limit").val(),
              type: $("#type").val(),
              keyword: $("#keyword").val(),
              minround: $("#minround").val(),
              maxround: $("#maxround").val(),
            }).done(function( data ) {
              $("#transactions").html(data);
        });
      }

      latest_transactions() {
        $.post(this.url, {
              action: "latest_transactions",
            }).done(function( data ) {
              $("#transactions").html(data);
        });
      }

      latest_blocks() {
        $.post(this.url, {
              action: "latest_blocks",
            }).done(function( data ) {
              $("#blocks").html(data);
        });
      }

      address(value) {
        $("#type").val("address");
        $("#keyword").val(value);
        this.search();
      }

      txid(value) {
        $("#type").val("txid");
        $("#keyword").val(value);
        this.search();
      }

      block(value) {
        $("#type").val("block");
        $("#keyword").val(value);
        this.search();
      }

      asset(value) {
        $("#type").val("asset");
        $("#keyword").val(value);
        this.search();
      }

      application(value) {
        $("#type").val("application");
        $("#keyword").val(value);
        this.search();
      }

}
