<template>
    <AuthenticatedLayout>
        <div>
            <!-- Optional: See-Name -->
            <h1 v-if="lake.name" class="text-2xl font-bold mb-2">
                {{ lake.name }}
            </h1>

            <canvas ref="myChart"></canvas>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import {
    Chart,
    LineController,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'

// Chart-Elemente registrieren
Chart.register(
    LineController,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

// Props vom Controller
const props = defineProps({
    temperatureData: {
        type: Array,
        default: () => []
    },
    oxygenData: {
        type: Array,
        default: () => []
    },
    lake: {
        type: Object,
        default: () => ({})
    }
})

const myChart = ref(null)

// Hilfsfunktion, um die letzten 30 Tage zu berechnen und im gewünschten Format zu liefern:
function getLast30DaysFormatted() {
    const dates = []
    const today = new Date()

    for (let i = 0; i < 30; i++) {
        // Neues Datum erzeugen
        const date = new Date(today)
        // Tag um i Tage zurücksetzen
        date.setDate(today.getDate() - i)

        // Formatierung z.B. "d.M." oder "dd.MM.yyyy"
        // Hier als Beispiel "d.M." (8.2. usw.)
        const day = date.getDate()
        const month = date.getMonth() + 1 // Monate 0-11
        dates.unshift(`${day}.${month}.`)
    }

    return dates
}

onMounted(() => {
    // Labels dynamisch generieren
    const labels = getLast30DaysFormatted()

    new Chart(myChart.value, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Temperatur (°C)',
                    data: props.temperatureData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    borderWidth: 2,
                    pointRadius: 2,
                    tension: 0.3,
                    fill: true,
                    yAxisID: 'yTemp'
                },
                {
                    label: 'Sauerstoff (mg/l)',
                    data: props.oxygenData,
                    borderColor: 'rgba(75, 192, 75, 1)',
                    backgroundColor: 'rgba(75, 192, 75, 0.1)',
                    borderWidth: 2,
                    pointRadius: 2,
                    tension: 0.3,
                    fill: true,
                    yAxisID: 'yO2'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Datum',
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        color: '#666',
                        font: { size: 12 }
                    },
                    grid: { color: '#ccc' }
                },
                yTemp: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Temperatur (°C)',
                        font: { size: 14, weight: 'bold' }
                    },
                    ticks: {
                        color: '#666',
                        font: { size: 12 }
                    }
                },
                yO2: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Sauerstoff (mg/l)',
                        font: { size: 14, weight: 'bold' }
                    },
                    grid: {
                        drawOnChartArea: false,
                        color: '#ccc'
                    },
                    ticks: {
                        color: '#666',
                        font: { size: 12 }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Verlauf 30 Tage',
                    font: { size: 16, weight: 'bold' },
                    padding: { top: 10, bottom: 10 }
                },
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                }
            }
        }
    })
})
</script>

<style scoped>
canvas {
    max-width: 100%;
    width: 100%;
    height: auto;
    margin: 0 auto;
    display: block;
}
</style>
