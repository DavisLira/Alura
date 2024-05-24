"""Valida a URL"""
import re

URL = 'https://www.bytebank.com.br/cambio'
PADRAO_URL = re.compile('(http(s)?://)?(www.)?bytebank.com(.br)?/cambio')
MATCH = PADRAO_URL.match(URL)

if not MATCH:
    raise ValueError("A URL não é válida")

print("A URL é válida")
