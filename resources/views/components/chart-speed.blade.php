@once

<script src="@asset('build/js/chart.js')"></script>

@endonce

<div class="box mt-5 p-5">
    <canvas id="{{ $id }}" height="300"></canvas>
</div>

<script>
const positions = {!! $positionsJson !!};

new Chart(document.getElementById('{{ $id }}'), {
    type: 'line',

    data: {
        labels: positions.map(position => position.date_at),

        datasets: [
            {
                label: '{{ __('map.speed') }}',
                data: positions.map(position => position.speed),
                pointRadius: 0,
                fill: false,
                pointRadius: 0,
                pointHitRadius: 10,
                steppedLine: false,
                borderColor: '#FF5252',
                borderWidth: 2,
                tension: 0.4
            }
        ]
    },

    options: {
        responsive:true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                display: false
            }
        },

        scales: {
            x: {
                ticks: {
                    autoSkip: true
                },
                grid: {
                    display: false
                }
            },

            y: {
                grace: '10%',
                beginAtZero: true,

                ticks: {
                    padding: 5
                }
            },
        },

        onClick: function (e, item) {
            const index = item[0].index;

            if (!positions[index]) {
                return;
            }

            const element = document.querySelector('[data-map-point="' + positions[index].id + '"]');

            if (element) {
                element.click();
            }
        }
    }
});
</script>
