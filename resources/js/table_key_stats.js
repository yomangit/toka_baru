var data_table = JSON.parse('<?php echo $key_state; ?>');
const tableBody = document.querySelector("#dataGrid tbody");
for (var i = 0; i < data_table.group.length; i++) {
 

    const row = `
        <tr class='text-center' >

        <td> </td>
        <td>${data_table.group[i]}</td>
        <td>${data_table.fai[i]}</td>
      
        
        </tr>
        `;
    tableBody.innerHTML += row;
}
