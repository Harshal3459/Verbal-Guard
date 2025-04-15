from flask import Flask, jsonify, request
from vaderSentiment.vaderSentiment import SentimentIntensityAnalyzer
import os  

app = Flask(__name__)


analyzer = SentimentIntensityAnalyzer()

@app.route('/detect_hate_speech', methods=['POST'])
def detect_hate_speech():
    comment = request.json['comment']

    
    print("Inside detect_hate_speech function")  
    score = analyzer.polarity_scores(comment)['compound']

    threshold = -0.5  

    if score <= threshold:
        print("Hate speech detected!")
        is_hate_speech = True
    else: 
        print("Not hate speech.")
        is_hate_speech = False

    return jsonify({'hate_speech': is_hate_speech}) 

if __name__ == '__main__':
    app.run(debug=True)