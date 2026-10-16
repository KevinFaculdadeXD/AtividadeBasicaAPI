const express = require('express');
const app = express();
const API = 'http://localhost:8000/api/tarefas';
const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' };

app.use(express.json());

// Lista as tarefas em uma página HTML simples
app.get('/', async (req, res) => {
  const resp = await fetch(API, { headers });
  const { data } = await resp.json();

  const itens = data.map(t =>
    `<li>${t.concluida ? '✅' : '⬜'} <b>${t.titulo}</b> - ${t.descricao ?? ''} <small>(${t.criada_em})</small></li>`
  ).join('');

  res.send(`<h1>Minhas Tarefas</h1><ul>${itens}</ul>`);
});

// Cria uma tarefa via proxy
app.post('/tarefas', async (req, res) => {
  const resp = await fetch(API, {
    method: 'POST', headers, body: JSON.stringify(req.body)
  });
  res.status(resp.status).json(await resp.json());
});

// Marca como concluída
app.patch('/tarefas/:id/concluir', async (req, res) => {
  const resp = await fetch(`${API}/${req.params.id}`, {
    method: 'PUT', headers, body: JSON.stringify({ concluida: true })
  });
  res.status(resp.status).json(await resp.json());
});

app.listen(3000, () => console.log('Cliente em http://localhost:3000'));