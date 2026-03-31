#!/usr/bin/env bash
set -euo pipefail

TARGET_DIR="${1:-/home/diary/Documents/L3/S5/prog/git/WebDesignBinome/uploads/articles}"
MAX_SIZE="1600x1600>"
JPEG_QUALITY=82
WEBP_QUALITY=80
WEBP_SIZES=(600 1200)

if [ ! -d "$TARGET_DIR" ]; then
  echo "Target directory not found: $TARGET_DIR" >&2
  exit 1
fi

BACKUP_DIR="$TARGET_DIR/originals"
mkdir -p "$BACKUP_DIR"

shopt -s nullglob

optimize_image() {
  local img="$1"
  local filename
  filename=$(basename "$img")

  if [ ! -f "$BACKUP_DIR/$filename" ]; then
    cp "$img" "$BACKUP_DIR/$filename"
  fi

  case "${img,,}" in
    *.jpg|*.jpeg)
      convert "$img" -strip -resize "$MAX_SIZE" -quality "$JPEG_QUALITY" -interlace JPEG -define jpeg:dct-method=float "$img"
      ;;
    *.png)
      convert "$img" -strip -resize "$MAX_SIZE" -quality "$JPEG_QUALITY" "$img"
      ;;
  esac

  local webp_base="${img%.*}"
  local webp_full="${webp_base}.webp"
  convert "$img" -strip -resize "$MAX_SIZE" -quality "$WEBP_QUALITY" "$webp_full"

  for size in "${WEBP_SIZES[@]}"; do
    local webp_variant="${webp_base}@${size}.webp"
    convert "$img" -strip -resize "${size}x${size}>" -quality "$WEBP_QUALITY" "$webp_variant"
  done
}

for img in "$TARGET_DIR"/*.{jpg,jpeg,png,JPG,JPEG,PNG}; do
  optimize_image "$img"
  echo "Optimized: $img"
done

printf "\nDone. Originals saved in: %s\n" "$BACKUP_DIR"
