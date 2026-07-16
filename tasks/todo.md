# Todo: Homepage Hero Polish

## Phase 1: Foundation & quick win
- [x] Task 1: Floating WhatsApp button di beranda
- [x] Task 2: Migration + model — kolom `logo` di `school_settings`

### Checkpoint: Foundation
- [ ] `composer run test` hijau
- [ ] Tombol WA jalan di browser (manual)
- [ ] Kolom `logo` ada di DB, model bisa fillable

## Phase 2: Core feature — logo end-to-end
- [x] Task 3: Admin bisa upload/ganti/hapus logo di `/admin/settings`
- [x] Task 4: Homepage — logo overlay + headline/tagline visible

### Checkpoint: Core Feature
- [ ] `composer run test` hijau
- [ ] Upload logo di admin → langsung kelihatan di beranda (manual end-to-end)
- [ ] Fallback teks jalan kalau logo belum/dihapus

## Phase 3: Polish visual
- [x] Task 5: Pagination premium (numbered/progress bar)
- [x] Task 6: Ken Burns effect + `prefers-reduced-motion` guard

### Checkpoint: Complete
- [x] `composer run test` full green (69/69), `vendor/bin/pint` bersih, `npm run build` sukses
- [ ] End-to-end manual: logo+fallback, headline, WA button, pagination, Ken Burns, toggle `prefers-reduced-motion` — **belum dicek di browser**
- [x] Viewport pertama tetap fullscreen carousel, tidak ada footer/section baru
- [x] Semua Success Criteria di `docs/spec-homepage-hero-polish.md` terpenuhi (via test otomatis; manual masih tertunda)

## Open Questions
- [ ] Konfirmasi copy headline/tagline final dari tim marketing
