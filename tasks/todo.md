# Todo: Homepage Hero Polish

## Phase 1: Foundation & quick win
- [x] Task 1: Floating WhatsApp button di beranda
- [x] Task 2: Migration + model — kolom `logo` di `school_settings`

### Checkpoint: Foundation
- [x] `composer run test` hijau
- [ ] Tombol WA jalan di browser (manual — belum dicek)
- [x] Kolom `logo` ada di DB, model bisa fillable

## Phase 2: Core feature — logo end-to-end
- [x] Task 3: Admin bisa upload/ganti/hapus logo di `/admin/settings`
- [x] ~~Task 4: Homepage — logo overlay + headline/tagline visible~~ — headline/tagline direvisi, lihat Task 8

### Checkpoint: Core Feature
- [x] `composer run test` hijau
- [ ] Upload logo di admin → langsung kelihatan di beranda (manual end-to-end — belum dicek)
- [x] Fallback teks jalan kalau logo belum/dihapus

## Phase 3: Polish visual
- [x] Task 5: Pagination premium (numbered/progress bar)
- [x] ~~Task 6: Ken Burns effect + `prefers-reduced-motion` guard~~ — direvisi, lihat Task 7

## Phase 4: Revisi
- [x] Task 7: Cabut efek Ken Burns dari foto slide (foto marketing sudah ada teks tertanam)
- [ ] Task 8: Cabut headline + tagline overlay (dua lapis teks di foto susah dibaca)
- [ ] Task 9: Foto slide full-bleed `object-cover` di semua breakpoint (hapus blurred-backdrop trick)

### Checkpoint: Complete
- [ ] `composer run test` full green, `vendor/bin/pint` bersih, `npm run build` sukses (recheck setelah Task 8-9)
- [ ] End-to-end manual: logo+fallback, WA button, pagination, foto statis full-bleed (tanpa zoom, tanpa headline), toggle `prefers-reduced-motion` — **belum dicek di browser**
- [x] Viewport pertama tetap fullscreen carousel, tidak ada footer/section baru
- [ ] Semua Success Criteria di `docs/spec-homepage-hero-polish.md` terpenuhi (recheck setelah Task 8-9)

## Open Questions
(tidak ada lagi — headline/tagline sudah dihapus total)
