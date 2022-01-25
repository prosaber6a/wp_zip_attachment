;
(function($) {
    $(document).ready(function() {
        $('#prozip_generate_pdf').hide();
        $('#prozip_product_select').on('change', function() {
            const product_id = parseInt($(this).val());
            $('#prozip_ajax_response').html('');
            if ($('#prozip_product_select option:selected').text() != '') {
                $('#prozip_product_name').html('Select Tech and Specs:  ' + $('#prozip_product_select option:selected').text());
            } else {
                $('#prozip_product_name').html('');
            }
            $('#prozip_generate_pdf').hide();
            if (isNaN(product_id)) {
                return;
            }
            $.ajax({
                type: "POST",
                dataType: "json",
                url: my_ajax_object.ajax_url,
                data: { action: "prozip_get_product_meta", product_id: product_id, },
                success: function(response) {
                    console.log('success', response);
                    let html = "";
                    let i = 0;
                    let j = 0;
                    response.data.forEach((e) => {
                        html += `
                        <div class="list_container">
                            <h4><a href="#" onclick="prozip_show_hide('tech_space_${i}')" class="parent_list_anchor"><span class="parent_list_anchor_before"><i class="fa fa-chevron-right"></i></span>${e.tech_space_group_name}</a></h4>
                            <div id="tech_space_${i}" style="display:none">
                        `;
                        j = 0;
                        e.options.forEach((d) => {
                            html += `<p>
                            <input name="prozip_selected_option[]" value="${d.pdf_file.id}" type="checkbox" id="prozip_checkbox_${i}_${j}" />
                            <label for="prozip_checkbox_${i}_${j}">
                            ${d.option}
                            </label>
                            </p>`;
                            j++;
                        });
                        i++;
                        html += "</div></div>";
                    });
                    $('#prozip_ajax_response').html(html);
                    $('#prozip_generate_pdf').show();

                },
                error: function(response) {
                    alert('An error occoured on post product id');
                }
            });
        });

        $('#prozip_generate_pdf').on('click', function() {
            const fileIds = $('[name="prozip_selected_option[]"]')
                .map(function() { return $(this).val(); }).get();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: my_ajax_object.ajax_url,
                data: { action: "prozip_pdf_zip", fileIds: fileIds, },
                success: function(response) {
                    console.log('success', response);
                    window.open(response.data);

                },
                error: function(response) {
                    alert('An error occoured on post product id');
                }
            });
        });
    });
})(jQuery)



function prozip_show_hide(div) {
    const x = document.getElementById(div);
    console.log(x);
    if (x.style.display === "none") {
        x.parentElement.getElementsByTagName('span')[0].innerHTML = '<i class="fa fa-chevron-down"></i>';
        x.style.display = "block";
    } else {
        x.parentElement.getElementsByTagName('span')[0].innerHTML = '<i class="fa fa-chevron-right"></i>';
        x.style.display = "none";
    }
}