/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function json(p_url, cbf)
{
    $.ajax(
            {
                url: p_url,
                type: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "text",
                success: function (data) {
                    cbf(data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus + "\nError: " + errorThrown);
                }
            });
}