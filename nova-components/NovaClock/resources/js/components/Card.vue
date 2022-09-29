<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3">
      <Clock :blink="card.blink" :displaySeconds="card.displaySeconds" />
    </div>
  </Card>
</template>

<script>
import Clock from 'vue-digital-clock'
  
export default {
  props: [
    'card',

    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],

  components: {
    Clock,
  },

  mounted() {
    //
  },
}
</script>
