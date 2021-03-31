$(document).ready(function(){

      wallet = new Wallet();
      wallet.list();

      $("#wallet_load_keys").click(function(){
        var id_wallet=$("#wallets").val();
          wallet.list_keys();
      });

      $("#key_copy").click(function(){
        $("#tmp").val($("#keys option:selected").val());
        $("#tmp").focus();
        $("#tmp").select();
        document.execCommand('copy');
      });

      $("#wallet_create").click(function(){
          wallet.create();
      });

      $("#wallet_rename").click(function(){
          wallet.rename();
      });

      $("#wallet_info").click(function(){
          wallet.info();
      });

      $("#transaction_info").click(function(){
          wallet.transaction_info();
      });

      $("#key_generate").click(function(){
          wallet.key_generate();
      });

      $("#key_balance").click(function(){
          wallet.key_balance();
      });

      $("#send").click(function(){
          wallet.send();
      });


      $("#key_delete").click(function(){
        var r = confirm("Are you sure you want to remove this key?");
          if (r == true) {
            wallet.key_delete();
          }
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

      create() {
        $.post(this.url, {
              action: "create",
              wallet_name: $("#wallet_name").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      rename() {
        $.post(this.url, {
              action: "rename",
              wallet_id: $("#wallets option:selected").val(),
              wallet_name: $("#wallet_name").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list();
              var obj = $.parseJSON(data);
              console.log(obj);
        });
      }

      info() {
        $.post(this.url, {
              action: "info",
              wallet_id: $("#wallets option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              var obj = $.parseJSON(data);
              console.log(obj);
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

      key_generate() {
        $.post(this.url, {
              action: "key_generate",
              wallet_password: $("#wallet_password").val(),
              wallet_id: $("#wallets option:selected").val(),
            }).done(function( data ) {
              alert(data);
              $("#wallet_output").val(data);
              wallet.list_keys();
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

      key_delete() {
        $.post(this.url, {
              action: "key_delete",
              wallet_id: $("#wallets option:selected").val(),
              key_id: $("#keys option:selected").val(),
              wallet_password: $("#wallet_password").val(),
            }).done(function( data ) {
              $("#wallet_output").val(data);
              wallet.list_keys();
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

        send() {
          $.post(this.url, {

                action: "send",
                wallet_id: $("#wallets option:selected").val(),
                key_id: $("#keys option:selected").val(),
                wallet_password: $("#wallet_password").val(),
                to: $("#to").val(),
                amount: $("#amount").val(),
                note: $("#note").val(),

              }).done(function( data ) {
                $("#wallet_output").val(data);
                var obj = $.parseJSON(data);
                console.log(obj);
          });
        }


}
