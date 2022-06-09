<template>
  <div :style="cssVars">
    <ul class="timeline">
        <li v-for="(item, key) in timeline" :key="key">
            {{ item.title }}
            <div class="float-right">{{ formatDate(item.date) }}</div>
            <p>{{ item.content }}</p>
        </li>
    </ul>
  </div>
</template>

<script>
export default {
    props: {
        timeline: {
            
        },
        color: {

        }
    },
    methods: {
        formatDate(datetime) {
            var date = new Date(datetime)
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        }
    },
    computed: {
      cssVars () {
        return{
          '--color': this.color,
        }
      }
    }
}
</script>

<style>
ul.timeline {
    list-style-type: none;
    position: relative;
    padding-left: 35px;
    z-index: 1;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
    margin-top: 6px;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 20px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid;
    border-color: var(--color);
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
    margin-top: 6px;
}
ul.timeline > li p {
  font-size: 0.8rem;
  line-height: 1.8;
}
</style>