candidates = [];
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
  candidates.splice(14);
}