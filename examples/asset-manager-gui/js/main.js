$(document).ready(function(){

      wallet = new Wallet();
      wallet.list();

      $("#wallet_load_keys").click(function(){
          wallet.list_keys();
      });

      $("#key_copy").click(function(){
        $("#tmp").val($("#keys option:selected").val());
        $("#tmp").focus();
        $("#tmp").select();
        document.execCommand('copy');
      });

      $("#key_load_assets").click(function(){
          wallet.list_assets();
      });

      $("#keys").change(function(){
          wallet.list_assets();
      });

      $("#transaction_info").click(function(){
          wallet.transaction_info();
      });

      $("#key_balance").click(function(){
          wallet.key_balance();
      });

      $("#asset_info").click(function(){
          wallet.asset_info();
      });

      $("#asset_optin").click(function(){
          wallet.asset_optin();
      });

      $("#send, #send_asset").click(function(){
          wallet.send();
      });

      $("#asset_send").click(function(){
          $("#transaction_type").val("send");
          $("#asset_box_send").slideDown();
          $("#asset_box_studio").slideUp();
      });

      $("#asset_create").click(function(){
          $("#asset_box_studio h2").html("Create ASA");
          $("#transaction_type").val("create_asa");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown();
          $("#nft").slideUp();
      });
      $("#asset_create_nft").click(function(){
          $("#asset_box_studio h2").html("Create NFT");
          $("#transaction_type").val("create_nft");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown();
          $("#nft").slideDown();
          $("#asset_box_studio #decimals").parent().css("display","none");
          $("#asset_box_studio #total").parent().css("display","none");
      });
      $("#asset_reconfigure").click(function(){
          $("#asset_box_studio h2").html("Reconfigure Asset");
          $("#transaction_type").val("reconfigure");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
          });

          $("#nft").slideUp();
      });

      $("#asset_destroy").click(function(){
          $("#asset_box_studio h2").html("Destroy Asset");
          $("#transaction_type").val("destroy");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #freeze_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#asset_freeze").click(function(){
          $("#asset_box_studio h2").html("Freeze Account");
          $("#transaction_type").val("freeze");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#asset_unfreeze").click(function(){
          $("#asset_box_studio h2").html("Unfreeze Account");
          $("#transaction_type").val("unfreeze");
          $("#asset_box_send").slideUp();
          $("#asset_box_studio").slideDown();
          $("#asset_box_studio *:not(#nft)").slideDown(function(){
              $("#asset_box_studio #asset_name").parent().css("display","none");
              $("#asset_box_studio #unit_name").parent().css("display","none");
              $("#asset_box_studio #decimals").parent().css("display","none");
              $("#asset_box_studio #total").parent().css("display","none");
              $("#asset_box_studio #url").parent().css("display","none");
              $("#asset_box_studio #clawback_address").parent().css("display","none");
              $("#asset_box_studio #reserve_address").parent().css("display","none");
              $("#asset_box_studio #manager_address").parent().css("display","none");
          });
          $("#nft").slideUp();
      });

      $("#meta_hash").click(function(){
          wallet.meta_hash();
      });

});


class Wallet {

      url="php/controller.php";

      list() {
        $.post(this.url, {
              action: "list",
            }).done(function( data ) {
              var obj = $.parseJSON(data);
              $("#wallets").html("");
              $.each(obj.wallets, function(index,itemx) {
                    $("#wallets").append('<option value="' + itemx.id + '">' + itemx.name + '</option>');
          		});
        });
      }

      transaction_info() {
        $.post(this.url, {
              action: "transaction_info",
              key_id: $("#keys option:selected").val(),
              transaction_id: $("#transaction_id").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      key_balance() {
        $.post(this.url, {
              action: "key_balance",
              key_id: $("#keys option:selected").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }


      list_keys() {
        $.post(this.url, {
              action: "list_keys",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {

              var obj = $.parseJSON(data);
              console.log(obj);
              $("#keys").html("");
              $.each(obj.addresses, function(index,itemx) {
                  $("#keys").append('<option value="' + itemx + '">' + itemx + '</option>');
                });

        });
      }


     list_assets() {
        $.post(this.url, {
              action: "list_assets",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
              key_id: $("#keys option:selected").val(),
            }).done(function( data ) {

              var obj = $.parseJSON(data);
              console.log(obj);
              $("#assets").html("");
              $.each(obj, function(index,itemx) {
                  $("#assets").append('<option value="' + index + '">' + itemx + '</option>');
              });

        });
      }

     asset_info() {
        $.post(this.url, {
              action: "asset_info",
              asset_id: $("#assets option:selected").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

     send() {

        var asset=$("#assets option:selected").val();
        if(asset ||  $("#transaction_type").val()=="create_asa" || $("#transaction_type").val()=="create_nft"){

          $.post(this.url, {
                action: "send",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                transaction_type: $("#transaction_type").val(),
                asset_id: asset,
                clawback: $("#clawback").val(),
                to: $("#to").val(),
                amount: $("#amount").val(),
                note: $("#note").val(),
                asset_name: $("#asset_name").val(),
                unit_name: $("#unit_name").val(),
                decimals: $("#decimals").val(),
                total: $("#total").val(),
                url: $("#url").val(),
                clawback_address: $("#clawback_address").val(),
                freeze_address: $("#freeze_address").val(),
                reserve_address: $("#reserve_address").val(),
                manager_address: $("#manager_address").val(),
                meta_data_hash: $("#meta_data_hash").val(),
                asset_note: $("#asset_note").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }else{
            alert("Select an Asset.");
        }
     }

      asset_optin() {
          $.post(this.url, {
                action: "asset_optin",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                asset_id: $("#asset_id").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }

     meta_hash() {
        $.post(this.url, {
              action: "meta_hash",
              asset_note: $("#asset_note").val(),
            }).done(function(data) {
              $("#meta_data_hash").val(data);
        });
      }

}
