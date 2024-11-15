from flask import Flask, request, jsonify
import numpy as np
from tensorflow.keras.models import load_model

app = Flask(__name__)
model = load_model("models/simple baseline lstm.h5")

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()  # Receive JSON data
    sequence = np.array(data["sequence"]).reshape(1, -1, 1)  # Reshape for LSTM
    prediction = model.predict(sequence)
    return jsonify({"prediction": prediction.tolist()})

if __name__ == '__main__':
    app.run(debug=True)
