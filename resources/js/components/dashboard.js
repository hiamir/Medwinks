import Chart from 'chart.js/auto';
import moment from "moment/moment";

document.addEventListener('alpine:init', function () {
    Alpine.data('Dashboard', ($wire, data) => ({
        myChart: "",
        chartInitialized: false,
        chartData: $wire.entangle('chartData'),

        labels: moment.months({count: 7}),

        myData: {},

        config: {},

        init() {

            console.log(this.chartData['label']);
            Alpine.effect(() => {
                this.myData = {
                    labels: this.chartData['label'],
                    datasets: [{
                        label: 'New applications',
                        data: this.chartData['data'],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                };


                this.config = {
                    type: 'bar',
                    data: this.myData,
                    options: {
                        responsive: true,
                        aspectRatio: 1,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,

                                title: {
                                    display: true,
                                    text: 'Number of Applications'
                                },
                                min: 0,
                                ticks: {
                                    // forces step size to be 50 units
                                    stepSize: 1
                                }
                            }
                        },
                        // plugins: {
                        //     title: {
                        //         display: true,
                        //         text: 'TEST',
                        //         position: 'start'
                        //     },
                        //
                        // }
                    }
                };
                if (!this.chartInitialized) {
                    this.myChart = new Chart(document.getElementById('myChart'), this.config);
                    this.chartInitialized = true;
                }

            });
        }
    }));


});
