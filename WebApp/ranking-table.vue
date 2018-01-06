<template>
  <div class="container table-header">
    <div class="row">
      <div class="col-2">#</div>
      <div class="col-6">Name</div>
      <div class="col-2">Score</div>
    </div>
  </div>

  <transition-group tag="ul" name="table" class="container table-body">
    <li v-for="(cd, index) in candidates" :key="cd.id" v-bind:class="{'text-success': cd.isNew}" class="row">
      <div class="col-2"> {{ index +1 }}</div>
      <div class="col-6">{{ cd.name }}</div>
      <div class="col-2"><strong>{{cd.score}}</strong></div>
    </li>
  </transition-group>
</template>


new Vue({
      el: '#ranking-table',
      data: {
        candidates: candidates
      },
      methods: {
        addCandidate: addCandidate
      }
    });


counter = 1;
function addCandidate() {
  let candidate = {
    id: counter,
    name: 'Test Candidate ' + counter,
    score: Math.round(((Math.random() * 100) % 36) * 100) / 100,
    isNew: true
  };
  counter++;

  let previous = candidates.find(e => e.isNew);
  if (previous)
    previous.isNew = false;

  candidates.push(candidate);
  candidates.sort((a, b) => b.score - a.score);
  candidates.splice(15);
}