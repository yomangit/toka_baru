<div>
    @vite(['resources/js/apexchart.js'])

    <div class="w-full my-2 shadow stats">
        <div class="stat">
            <div class="stat-figure text-primary">
                <x-svg-hazard />
            </div>
            <div class="stat-title">Hazard Report</div>
            <div class="stat-value text-primary">{{ $count_hazard }}</div>
            <div class="stat-desc">Periode {{ $month }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-svg-incident />
            </div>
            <div class="stat-title">Incident Report</div>
            <div class="stat-value text-secondary">{{ $count_incident }}</div>
            <div class="stat-desc">Periode {{ $month }}</div>
        </div>
        <div class="stat">
            <div class="stat-figure text-secondary">
                <x-svg-pto />
            </div>
            <div class="stat-title">PTO Report</div>
            <div class="stat-value text-secondary">{{ $count_pto }}</div>
            <div class="stat-desc">Periode {{ $month }}</div>
        </div>


    </div>

    <div class=" bg-slate-300" id="all_injury_vs_ltifr"></div>
    <div class="my-2 overflow-x-auto">
        <div class="flex gap-2">
            <div class="grow">
                <table class="table table-xs table-zebra"id="dataGrid">
                    <thead>
                        <tr class='text-center bg-slate-400 '>
                            <th></th>
                            <th>Group</th>
                            <th>FAI (YTD)</th>
                            <th>MTI (YTD)</th>
                            <th>RDI (YTD)</th>
                            <th>LTI (YTD)</th>
                            <th>LTIFR(12 MMA)</th>
                            <th>PLTI(YTD)</th>
                            <th>PLTI(Previouse Year)</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="shadow stats bg-accent text-accent-content">
                <div class="stat">
                    <div
                        class="text-transparent stat-title font-signika bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                        Manhours LTI Free</div>
                    <div class="stat-value font-signika ">{{ $manhoursltifree }}</div>
                    <div class="font-semibold stat-desc">periode {{ $month }}</div>
                </div>
            </div>
        </div>
        <div id="table-gridjs"></div>
    </div>
    <div class="grid grid-rows-4 gap-2 lg:grid-cols-2 ">
        <div class="my-2 bg-slate-300 lg:my-0" id="lagging_and_leading_indicator_12Months"></div>
        <div class="my-2 bg-slate-300 lg:my-0" id="ohs_incident_deptCont"></div>
        <div class="my-2 bg-slate-300 lg:my-0" id="cause_analysis"></div>
        <div class="my-2 bg-slate-300 lg:my-0" id="lagging_and_leading_indicator_status"></div>
    </div>
</div>


<script>
    var data_table = JSON.parse('<?php echo $key_state; ?>');
    const tableBody = document.querySelector("#dataGrid tbody");



    for (var i = 0; i < data_table.group.length; i++) {

        const row = `
            <tr class='text-center ' >

            <td> </td>
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
</script>
<script type="text/javascript" nonce="{{ csp_nonce() }}">
    const chartData = JSON.parse('<?php echo $Incident; ?>');

    var all_injury_vs_ltifr = {
        series: [{
            name: 'LTI',
            type: 'column',

            data: chartData.LTI
        }, {
            name: 'MTI',
            type: 'column',
            data: chartData.MTI
        }, {
            name: 'RDI',
            type: 'column',
            data: chartData.RDI
        }, {
            name: 'FAI',
            type: 'column',

            data: chartData.FAI
        }, {
            name: 'LTIFR',
            type: 'line',

            data: chartData.LTIFR
        }, {
            name: 'LTIFR Target',
            type: 'line',

            data: chartData.LTIFR_Target
        }],
        chart: {
            height: 350,
            type: 'line',
            stacked: false
        },
        zoom: {
            enabled: false
        },
        colors: ['#8A0100', '#B89242', '#F1F500', '#006F26', '#F50400', '#8079C7'],
        stroke: {
            width: [1, 1, 1, 1, 3, 4],
            dashArray: [0, 0, 0, 0, 0, 4],
            curve: 'smooth'
        },
        title: {
            text: 'All Injury VS LTIFR (24MMA)',
            align: 'center',
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                fontFamily: undefined,
                color: '#fb7185'
            },
        },
        xaxis: {
            categories: chartData.months,
        },
        yaxis: {
            title: {
                text: 'Points',
            }
        },
        tooltip: {
            fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
            },
        },
        legend: {
            horizontalAlign: 'center',
            offsetX: 40
        }
    };
    var lagging_and_leading = JSON.parse('<?php echo $Lead_vs_Lag; ?>');
    var lagging_and_leading_indicator_12Months = {
        series: [{
                name: "Total Lead",
                data: lagging_and_leading.total_lead
            },
            {
                name: "Incident",
                data: lagging_and_leading.incident
            }
        ],
        chart: {
            height: 350,
            type: 'line',
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            },
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#77B6EA', '#545454'],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            width: [2, 2],
        },
        title: {
            text: '12 Months Lagging & Leading Indicator',
            align: 'center',
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                fontFamily: undefined,
                color: '#fb7185'
            },
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: lagging_and_leading.date,

        },

        legend: {
            position: 'bottom',
            horizontalAlign: 'center',


        }
    };
    var incident_deptCont = JSON.parse('<?php echo $responsible_cont_dept; ?>');
    var ohs_incident_deptCont = {
        series: [{
            name: 'Open',
            data: incident_deptCont.open
        }, {
            name: 'Closed',
            data: incident_deptCont.closed
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: false
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: -10
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10

            },
        },
        xaxis: {

            categories: incident_deptCont.name,
        },
        title: {
            text: 'OHS Incidents Responsibility By Department & Contractor in ' + incident_deptCont.years,
            align: 'left',
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                fontFamily: undefined,
                color: '#fb7185'
            },
        },
        legend: {
            position: 'bottom',

        },
        fill: {
            opacity: 1
        }
    };
    var condition = JSON.parse('<?php echo $condition; ?>');
    var action = JSON.parse('<?php echo $action; ?>');
    console.log(condition);

    var cause_analysis = {
        series: [action, condition, ],
        chart: {
            width: 480,
            type: 'pie',
        },
        title: {
            text: '12 Months Leading Indicator Cause Analysis',
            align: 'center',
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                fontFamily: undefined,
                color: '#fb7185'
            },
        },
        labels: ['Action', 'Condition'],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var status_incident = JSON.parse('<?php echo $status_incident; ?>');
    var lagging_and_leading_indicator_status = {
        series: [{
            name: 'Open',
            data: status_incident.open
        }, {
            name: 'Closed',
            data: status_incident.closed
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: false
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                borderRadiusApplication: 'end', // 'around', 'end'
                borderRadiusWhenStacked: 'last',
                isFunnel: false,
                isFunnel3d: true,

            },
        },
        xaxis: {
            categories: status_incident.date
        },
        title: {
            text: '12 Months Leading Indicator Status',
            align: 'center',
            style: {
                fontSize: '12px',
                fontWeight: 'bold',
                fontFamily: undefined,
                color: '#fb7185'
            },
        },
        legend: {
            position: 'bottom',

        },
        fill: {
            opacity: 1
        }
    };
</script>
