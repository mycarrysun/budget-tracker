export default {
  maintainAspectRatio: false,
  scales: {
    yAxes: [
      {
        ticks: {
          min: 0
        }
      }
    ]
  },
  tooltips: {
    mode: 'index',
  },
  elements: {
    line: {
      fill: false,
      tension: 0.3,
    },
    point: {
      hitRadius: 16,
      hoverRadius: 8,
    }
  }
}