"""
remove_comments.py

Recorre un árbol de directorios y elimina comentarios de archivos de texto comunes.
- Hace copias de seguridad con extensión `.bak` antes de modificar.
- Maneja comentarios C-style (/* */, //), hash (#), y HTML <!-- -->.
- Intenta no eliminar texto dentro de comillas.

Uso:
    python remove_comments.py -p <path> [-n] [-v]

Opciones:
    -p, --path    Ruta raíz donde procesar (por defecto: current dir)
    -n, --nobackup No crear copias .bak
    -v, --verbose Mostrar resumen detallado

Nota: Haz una copia del repositorio si deseas más seguridad.
"""
import argparse
import os
import sys
import io
from typing import Tuple

TEXT_EXTENSIONS = {
    '.php', '.html', '.htm', '.js', '.css', '.sql', '.txt', '.json', '.xml', '.svg',
    '.py', '.java', '.c', '.cpp', '.h', '.ini', '.md', '.scss', '.less'
}


def is_binary_string(bytes_data: bytes) -> bool:
    if b'\0' in bytes_data:
        return True
    text_chars = bytes(range(32, 127)) + b'\n\r\t\f\b'
    nontext = bytes([b for b in bytes_data if b not in text_chars])
    return float(len(nontext)) / max(1, len(bytes_data)) > 0.30


def strip_c_style_comments(s: str, keep_trailing_newline=True) -> str:
    out = []
    i = 0
    n = len(s)
    state = 'NORMAL'
    while i < n:
        ch = s[i]
        nxt = s[i+1] if i+1 < n else ''
        if state == 'NORMAL':
            if ch == '/' and nxt == '*':
                state = 'MLC'
                i += 2
                continue
            if ch == '/' and nxt == '/':
                state = 'SLC'
                i += 2
                continue
            if ch == '#' :
                state = 'SLC'
                i += 1
                continue
            if ch == '"':
                out.append(ch); state = 'DQUOTE'; i += 1; continue
            if ch == "'":
                out.append(ch); state = 'SQUOTE'; i += 1; continue
            if ch == '`':
                out.append(ch); state = 'BTICK'; i += 1; continue
            out.append(ch); i += 1
            continue

        if state == 'SLC':
            if ch == '\n':
                out.append(ch)
                state = 'NORMAL'
            i += 1
            continue

        if state == 'MLC':
            if ch == '*' and nxt == '/':
                state = 'NORMAL'
                i += 2
            else:
                i += 1
            continue

        if state == 'DQUOTE':
            out.append(ch)
            if ch == '\\':
                if i+1 < n:
                    out.append(s[i+1]); i += 2; continue
            if ch == '"':
                state = 'NORMAL'
            i += 1
            continue

        if state == 'SQUOTE':
            out.append(ch)
            if ch == '\\':
                if i+1 < n:
                    out.append(s[i+1]); i += 2; continue
            if ch == "'":
                state = 'NORMAL'
            i += 1
            continue

        if state == 'BTICK':
            out.append(ch)
            if ch == '\\':
                if i+1 < n:
                    out.append(s[i+1]); i += 2; continue
            if ch == '`':
                state = 'NORMAL'
            i += 1
            continue

    res = ''.join(out)
    if keep_trailing_newline and not res.endswith('\n') and s.endswith('\n'):
        res += '\n'
    return res


def strip_html_comments_and_script(s: str) -> str:
    out = []
    i = 0
    n = len(s)
    while i < n:
        low = s[i:i+8].lower()
        if low.startswith('<script'):
            j = s.find('>', i)
            if j == -1:
                out.append(s[i:]); break
            out.append(s[i:j+1])
            close = s.lower().find('</script>', j+1)
            if close == -1:
                inner = s[j+1:]
                inner_clean = strip_c_style_comments(inner)
                out.append(inner_clean)
                break
            inner = s[j+1:close]
            inner_clean = strip_c_style_comments(inner)
            out.append(inner_clean)
            out.append(s[close:close+9])
            i = close+9
            continue

        if s.startswith('<!--', i):
            j = s.find('-->', i+4)
            if j == -1:
                i = n; break
            i = j+3
            continue

        out.append(s[i]); i += 1

    return ''.join(out)


def strip_php_file(s: str) -> str:
    out = []
    i = 0
    n = len(s)
    while i < n:
        idx = s.find('<?', i)
        if idx == -1:
            out.append(strip_html_comments_and_script(s[i:]))
            break
        out.append(strip_html_comments_and_script(s[i:idx]))
        end = s.find('?>', idx+2)
        if end == -1:
            php_block = s[idx:]
            out.append(strip_c_style_comments(php_block))
            break
        php_block = s[idx:end+2]
        out.append(strip_c_style_comments(php_block))
        i = end+2

    return ''.join(out)


def process_file(path: str, nobackup: bool=False) -> Tuple[bool, str]:
    try:
        with open(path, 'rb') as f:
            data = f.read()
    except Exception as e:
        return False, f'read-error: {e}'
    if len(data) == 0:
        return False, 'empty'
    if is_binary_string(data[:4096]):
        return False, 'binary'
    try:
        text = data.decode('utf-8')
    except Exception:
        try:
            text = data.decode('latin-1')
        except Exception as e:
            return False, f'decode-error: {e}'

    root, ext = os.path.splitext(path.lower())
    orig = text
    if ext == '.php':
        new = strip_php_file(text)
    elif ext in ('.html', '.htm', '.svg', '.xml'):
        new = strip_html_comments_and_script(text)
    elif ext in ('.css',):
        new = strip_c_style_comments(text)
    elif ext in ('.js', '.java', '.c', '.cpp', '.h', '.scss', '.less'):
        new = strip_c_style_comments(text)
    elif ext in ('.py', '.ini', '.sql', '.txt', '.md', '.json'):
        new = strip_c_style_comments(text)
    else:
        new = strip_c_style_comments(text)

    if new != orig:
        if not nobackup:
            bak = path + '.bak'
            try:
                with open(bak, 'wb') as f:
                    f.write(data)
            except Exception as e:
                return False, f'backup-failed: {e}'
        try:
            with open(path, 'w', encoding='utf-8') as f:
                f.write(new)
        except Exception as e:
            return False, f'write-error: {e}'
        return True, 'modified'
    return False, 'unchanged'


def walk_and_process(root: str, nobackup: bool=False, verbose: bool=False):
    stats = {'files':0, 'modified':0, 'skipped':0}
    for dirpath, dirs, files in os.walk(root):
        dirs[:] = [d for d in dirs if d not in ('.git','node_modules','vendor','assets','webfonts')]
        for fname in files:
            path = os.path.join(dirpath, fname)
            stats['files'] += 1
            changed, reason = process_file(path, nobackup)
            if changed:
                stats['modified'] += 1
                if verbose:
                    print(f'MODIFIED: {path}')
            else:
                stats['skipped'] += 1
                if verbose and reason not in ('unchanged','empty'):
                    print(f'SKIP: {path} ({reason})')
    return stats


def main():
    p = argparse.ArgumentParser()
    p.add_argument('-p', '--path', default='.', help='Directorio raíz a procesar')
    p.add_argument('-n', '--nobackup', action='store_true', help='No crear copias .bak')
    p.add_argument('-v', '--verbose', action='store_true', help='Salida detallada')
    args = p.parse_args()
    root = os.path.abspath(args.path)
    print(f'Procesando: {root} (nobackup={args.nobackup})')
    stats = walk_and_process(root, nobackup=args.nobackup, verbose=args.verbose)
    print('\nResumen:')
    print(f"  Archivos escaneados: {stats['files']}")
    print(f"  Archivos modificados: {stats['modified']}")
    print(f"  Archivos sin cambio: {stats['skipped']}")


if __name__ == '__main__':
    main()
