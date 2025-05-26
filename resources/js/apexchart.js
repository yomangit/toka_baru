import ApexCharts from "apexcharts";

// star:chart
var all_injury = new ApexCharts(
    document.querySelector("#all_injury_vs_ltifr"),
    all_injury_vs_ltifr
);
var lagging_and_leading_indicator = new ApexCharts(
    document.querySelector("#lagging_and_leading_indicator_12Months"),
    lagging_and_leading_indicator_12Months
);
var ohs_incident_deptConts = new ApexCharts(
    document.querySelector("#ohs_incident_deptCont"),
    ohs_incident_deptCont
);
var cause_analysis_render = new ApexCharts(
    document.querySelector("#cause_analysis"),
    cause_analysis
);
var lagging_and_leading_indicator_statuss = new ApexCharts(
    document.querySelector("#lagging_and_leading_indicator_status"),
    lagging_and_leading_indicator_status
);

all_injury.render();
lagging_and_leading_indicator.render();
ohs_incident_deptConts.render();
cause_analysis_render.render();
lagging_and_leading_indicator_statuss.render();
// end:chart
