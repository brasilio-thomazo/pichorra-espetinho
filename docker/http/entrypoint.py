#!/usr/bin/python3

from flask import Flask, jsonify
from flask_cors import CORS
import subprocess

app = Flask(__name__)
CORS(app=app, resources={r"/api/*": {"origins": "*"}})


@app.route("/api/reload", methods=["POST"])
def reload():
    return jsonify([reload_fpm(), reload_nginx()])


def reload_nginx():
    command = ['sudo', 'service', 'nginx', 'reload']
    cmd = subprocess.run(command, stdout=subprocess.PIPE,
                         stderr=subprocess.PIPE, text=True)
    data = ''
    if cmd.stdout:
        data = cmd.stdout
    else:
        data = cmd.stderr
    result = {
        "command": ' '.join(command),
        "code": cmd.returncode,
        "data": data
    }
    return result


def reload_fpm():
    command = ['sudo', 'service', 'php8.2-fpm', 'reload']
    cmd = subprocess.run(command, stdout=subprocess.PIPE,
                         stderr=subprocess.PIPE, text=True)
    data = ''
    if cmd.stdout:
        data = cmd.stdout
    else:
        data = cmd.stderr
    result = {
        "command": ' '.join(command),
        "code": cmd.returncode,
        "data": data
    }
    return result


if __name__ == "__main__":
    subprocess.run(['sudo', 'nginx', '-t'])
    subprocess.run(['sudo', 'service', 'nginx', 'start'])
    subprocess.run(['sudo', 'php-fpm8.2', '-t'])
    subprocess.run(['sudo', 'service', 'php8.2-fpm', 'start'])
    app.run('0.0.0.0', 8080, debug=True)
