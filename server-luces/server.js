const express = require("express");
const axios = require("axios");
const cron = require("node-cron");
const app = express();

require("dotenv").config();

const port = process.env.PORT || 4000;
const gestion_host = process.env.GESTION_HOST || "http://127.0.0.1:8000";

app.use(express.json());

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

const terminarPedido = async (id, datetime) => {
    const url = `${gestion_host}/api/pedidos/terminar/${id}`;
    try {
        const response = await axios.post(url, {
            fecha_fin: datetime,
        });
        console.error("terminar pedido:", response.data);
        return response.data;
    } catch (error) {
        console.error("Error al terminar pedido", error.response.data);
    }
};

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
        console.log(`switch ${action}, device ${ip}`);
        res.json(result);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

app.post("/schedule-switch", (req, res) => {
    const { ip, port, deviceid, outlet, action, datetime, pedido_id } =
        req.body;

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
    console.log(`apagar pedido ${pedido_id},`, date);

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
                await terminarPedido(pedido_id, datetime);
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
