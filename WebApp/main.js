console.log('Konichiwa')
data = [];
for (let i = 0; i < 100; i++) {
  data.push({ name: 'Stephan', score: 22.5 });
}

data[5] = { name: 'Damon', score: 24 };

fetch('templates/form2.html')
  .then(res => res.text())
  .then(html => load(html, 'loader'))


