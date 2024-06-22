const express = require("express");
const axios = require("axios");
const cron = require("node-cron");
const app = express();
const port = 4000;

app.use(express.json());

// Función para enviar la solicitud a la API del Sonoff
const sendSonoffRequest = async (ip, port, deviceid, outlet, action) => {
    const url = `http://${ip}:${port}/zeroconf/switches`;
    const data = {
        deviceid,
        data: {
            switches: [{ switch: action, outlet }],
        },
    };

    try {
        const response = await axios.post(url, data);
        return response.data;
    } catch (error) {
        console.error("Error al llamar a la API del Sonoff:", error.message);
        throw new Error("Error al llamar a la API del Sonoff");
    }
};

const terminarPedido = async (id) => {
    const url = `http://127.0.0.1:8000/api/pedidos/terminar/${id}`;
    try {
        const response = await axios.post(url);
        return response.data;
    } catch (error) {
        console.error("Error al llamar a la API del Sonoff:", error.message);
    }
};

// Ruta para encender o apagar el interruptor inmediatamente
app.post("/switch", async (req, res) => {
    const { ip, port, deviceid, outlet, action } = req.body;

    if (!ip || !port || !deviceid || typeof outlet !== "number" || !action) {
        return res.status(400).json({ error: "Datos inválidos" });
    }

    try {
        const result = await sendSonoffRequest(
            ip,
            port,
            deviceid,
            outlet,
            action
        );
        res.json(result);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Ruta para programar una acción
app.post("/schedule-switch", (req, res) => {
    const { ip, port, deviceid, outlet, action, datetime , pedido_id} = req.body;

    if (
        !ip ||
        !port ||
        !deviceid ||
        typeof outlet !== "number" ||
        !action ||
        !datetime
    ) {
        return res.status(400).json({ error: "Datos inválidos" });
    }

    const date = new Date(datetime);
    console.log(date);
    if (isNaN(date.getTime())) {
        return res.status(400).json({ error: "Fecha y hora inválidas" });
    }

    const cronTime = `${date.getSeconds()} ${date.getMinutes()} ${date.getHours()} ${date.getDate()} ${
        date.getMonth() + 1
    } *`;

    cron.schedule(
        cronTime,
        async () => {
            try {
                await terminarPedido(pedido_id);
                console.log(`Acción ejecutada: ${action} en ${datetime}`);
            } catch (error) {
                console.error(
                    "Error al ejecutar la acción programada:",
                    error.message
                );
            }
        },
        {
            scheduled: true,
            timezone: "America/La_Paz",
        }
    );

    res.json({ message: "Acción programada", datetime, action });
});

app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
});
