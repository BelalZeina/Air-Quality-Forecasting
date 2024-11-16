from flask import Flask, render_template, request, jsonify
import pandas as pd
import numpy as np
import plotly.graph_objs as go
from plotly.utils import PlotlyJSONEncoder
import json
from tensorflow.keras.models import load_model
from tensorflow.keras.losses import MeanSquaredError

app = Flask(__name__)

model = load_model("models/simple baseline lstm.h5", compile=False)
model.compile(optimizer='adam', loss=MeanSquaredError())

# Load example data (replace with your actual dataset)
df = pd.read_csv("data/PM2.5.csv")
df["From Date"] = pd.to_datetime(df["From Date"], errors='coerce')

@app.route('/')
def dashboard():
    return render_template('dashboard.html')

@app.route('/get_plot', methods=['POST'])
def get_plot():
    start_date = request.json.get("start_date")
    end_date = request.json.get("end_date")
    action = request.json.get("action")

    if action == "range":
        filtered_df = df[(df["From Date"] >= start_date) & (df["From Date"] <= end_date)]
        x = filtered_df["From Date"].astype(str).tolist()
        y = filtered_df["PM2.5 (ug/m3)"].tolist()
    elif action == "predict":
        # Prepare last sequence
        last_sequence = df["PM2.5 (ug/m3)"].values[-30:].reshape(1, 30, 1)

        # Fill NaN values with mean of the sequence
        if np.isnan(last_sequence).any():
            sequence_mean = np.nanmean(last_sequence)  # Calculate mean of non-NaN values
            last_sequence = np.nan_to_num(last_sequence, nan=sequence_mean)

        # Generate future predictions
        predictions = []
        current_sequence = last_sequence

        for i in range(10):
            next_value = model.predict(current_sequence)[0, 0]
            predictions.append(next_value)
            next_value_reshaped = np.array(next_value).reshape(1, 1, 1)
            current_sequence = np.append(current_sequence[:, 1:, :], next_value_reshaped, axis=1)

        # Generate future dates
        last_date = df["From Date"].iloc[-1]
        future_dates = pd.date_range(start=last_date + pd.Timedelta(hours=1), periods=10, freq='H').astype(str).tolist()

        x = future_dates
        y = predictions

        print("Predicted Dates (x):", x)
        print("Predicted Values (y):", y)
    else:
        x, y = [], []

    graph = go.Figure()
    graph.add_trace(go.Scatter(x=x, y=y, mode="lines", name="Predicted Data", line=dict(color='red')))

    graph_json = json.dumps(graph, cls=PlotlyJSONEncoder)
    print("Graph JSON:", graph_json)

    return jsonify({"graph": graph_json})



if __name__ == '__main__':
    app.run(debug=True)
