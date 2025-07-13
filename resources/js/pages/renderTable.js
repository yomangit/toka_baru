window.renderHazardTable = function (keyStateJson) {
    const data_table = JSON.parse(keyStateJson);
    const tableBody = document.querySelector("#dataGrid tbody");

    if (!tableBody) return;

    for (let i = 0; i < data_table.group.length; i++) {
        const row = `
            <tr class="text-center">
                <td></td>
                <td>${data_table.group[i]}</td>
                <td>${data_table.fai[i]}</td>
                <td>${data_table.mti[i]}</td>
                <td>${data_table.rdi[i]}</td>
                <td>${data_table.lti[i]}</td>
                <td>${data_table.lti_fr[i]}</td>
                <td>${data_table.departement_incident[i]}</td>
                <td>${data_table.departement_incident_previouse[i]}</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    }
};
