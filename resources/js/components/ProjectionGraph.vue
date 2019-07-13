<template>
    <div class="projection-graph">
        <line-chart :chart-data="stats" :options="config"/>
    </div>
</template>

<script>
  let params = new URLSearchParams(window.location.search)
  import LineChart from './line'
  import axios from 'axios'

  function getTooltipData(tooltipItem, data, prop) {
    let index = tooltipItem[0].index,
      dsIndex = tooltipItem[0].datasetIndex
    let text = data.datasets[dsIndex][prop][index]
    return text || null
  }

  export default {
    components: {
      LineChart
    },

    data: () => ({
      stats: {},
      view: params.get('view'),
      start_amt: params.get('start_amt'),
      config: {
        tooltips: {
          callbacks: {
            footer: function (tooltipItem, data) {
              return getTooltipData(tooltipItem, data, 'footer')
            },
            afterFooter: function (tooltipItem, data) {
              return getTooltipData(tooltipItem, data, 'afterFooter')
            }
          }
        }
      }
    }),

    methods: {
      getStats() {
        axios.get('projection/stats', {
          params,
        }).then(({ data }) => {
          this.stats = data
        })
      }
    },

    mounted() {
      this.getStats()
    }
  }
</script>