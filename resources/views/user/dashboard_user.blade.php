@php

    $user = Auth::user();



    $today = \Carbon\Carbon::today();



    $membershipEnd = $user->membership_end

        ? \Carbon\Carbon::parse($user->membership_end)->startOfDay()

        : null;



    $membershipStart = $user->membership_start

        ? \Carbon\Carbon::parse($user->membership_start)->startOfDay()

        : null;



    $membershipActive =

        $user->membership_status === 'active'

        && $membershipEnd

        && $membershipEnd->gte($today)

        && (!$membershipStart || $membershipStart->lte($today));



    $remainingDays = $membershipActive

        ? (int) $today->diffInDays($membershipEnd)

        : 0;

@endphp

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>GYMBRO — Member Dashboard</title>

<style>

:root{--bg:#0b100e;--panel:#121a16;--panel2:#18231d;--line:#29372e;--text:#edf4ee;--muted:#91a196;--lime:#b8f34a;--lime2:#d4ff82;--danger:#ff7777;--radius:18px}

*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font-family:Inter,Segoe UI,Arial,sans-serif}button,input,select{font:inherit}

.app{display:block;min-height:100vh}.brand{display:flex;align-items:center;gap:11px;font-size:19px;font-weight:900;letter-spacing:1px;padding:0 10px}.brand-mark{height:37px;width:37px;border-radius:11px;background:var(--lime);color:#172016;display:grid;place-items:center;font-size:20px}.nav-label{color:#66766b;font-size:10px;font-weight:800;letter-spacing:1.5px;padding:0 12px;margin-bottom:8px}.nav{display:grid;gap:6px}.nav a{display:flex;align-items:center;gap:12px;padding:12px;border-radius:11px;color:#a9b7ad;text-decoration:none;font-size:13px;font-weight:650}.nav a.active,.nav a:hover{background:#213128;color:var(--lime)}.nav-icon{width:19px;text-align:center;font-size:16px}.sidebar-bottom{margin-top:auto;border:1px solid var(--line);background:var(--panel);border-radius:14px;padding:14px}.sidebar-bottom small{color:var(--muted)}.sidebar-bottom strong{display:block;margin:7px 0;color:var(--lime);font-size:13px}

main{padding:30px 38px 50px;max-width:1500px;width:100%;margin:0 auto}.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:30px}.breadcrumb{color:var(--muted);font-size:12px}.top-actions{display:flex;align-items:center;gap:14px}.icon-btn{height:40px;width:40px;border:1px solid var(--line);border-radius:12px;background:var(--panel);color:var(--text);cursor:pointer}.avatar{height:39px;width:39px;border-radius:50%;background:#304638;color:var(--lime);display:grid;place-items:center;font-weight:800}.logout-btn{height:40px;padding:0 14px;border:1px solid #654343;border-radius:12px;background:#211817;color:#ffaaaa;font-size:11px;font-weight:800;cursor:pointer;transition:.2s}.logout-btn:hover{background:#382020;border-color:#a45c5c}.welcome{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:25px}.eyebrow{font-size:10px;color:var(--lime);letter-spacing:1.8px;font-weight:800}.welcome h1{font-size:30px;margin:8px 0 7px;letter-spacing:-.8px}.welcome p{color:var(--muted);margin:0;font-size:13px}.primary{background:var(--lime);color:#152015;border:0;border-radius:11px;padding:12px 17px;font-size:12px;font-weight:850;cursor:pointer;transition:.2s}.primary:hover{background:var(--lime2);transform:translateY(-1px)}.secondary{background:#25352b;color:var(--lime);border:1px solid #3b5141;border-radius:10px;padding:10px 13px;font-weight:750;font-size:11px;cursor:pointer}.grid-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}.stat,.card{background:var(--panel);border:1px solid var(--line);border-radius:var(--radius)}.stat{padding:17px}.stat-head{display:flex;align-items:center;justify-content:space-between;color:var(--muted);font-size:11px}.stat-icon{height:31px;width:31px;display:grid;place-items:center;background:#24352a;color:var(--lime);border-radius:9px;font-size:15px}.stat strong{display:block;font-size:24px;margin:13px 0 4px}.stat small{color:var(--muted);font-size:10px}.content-grid{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(280px,.9fr);gap:17px}.card{padding:20px;margin-bottom:17px}.card-title{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:17px}.card-title h2{font-size:15px;margin:0}.subtle{color:var(--muted);font-size:11px}.membership{background:linear-gradient(120deg,#1e3327,#142019 75%);border:1px solid #3a563f;position:relative;overflow:hidden}
.next-session{background:linear-gradient(115deg,#18271d,#121a16);border-color:#42563e}
.next-session-content{display:flex;align-items:center;gap:14px}
.next-session-date{min-width:58px;text-align:center;padding:10px 8px;background:#2a3d2d;border-radius:11px}
.next-session-date b{display:block;font-size:23px;color:var(--lime)}
.next-session-date small{font-size:9px;color:#c1d0c3;font-weight:800}
.next-session-info{flex:1;min-width:0}
.next-session-info strong{display:block;font-size:13px;margin-bottom:5px}
.next-session-info small{font-size:10px;color:var(--muted)}
.next-session-status{font-size:9px;color:var(--lime);white-space:nowrap}
.membership:after{content:"";position:absolute;width:190px;height:190px;border:1px solid #426044;border-radius:50%;right:-55px;top:-85px;box-shadow:0 0 0 22px #ffffff05,0 0 0 45px #ffffff03}.membership-top{display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1}.pill{font-size:9px;font-weight:850;padding:6px 9px;border-radius:20px;background:#29432e;color:var(--lime)}.membership h2{font-size:23px;margin:16px 0 5px}.membership p{font-size:11px;color:#b3c3b6;margin:0}.progress{height:7px;background:#34483a;border-radius:20px;margin:18px 0 9px;overflow:hidden}.progress span{display:block;width:34%;height:100%;background:var(--lime);border-radius:20px}.membership-foot{display:flex;justify-content:space-between;color:#b6c7b9;font-size:10px}.trainer-row{display:flex;gap:13px;align-items:center}.trainer-photo{height:54px;width:54px;border-radius:13px;background:linear-gradient(145deg,#455b4a,#1c2b21);display:grid;place-items:center;font-size:24px}.trainer-info{flex:1}.trainer-info strong{font-size:13px;display:block;margin-bottom:5px}.trainer-info small{font-size:10px;color:var(--muted)}.tag{font-size:9px;padding:5px 8px;border:1px solid #405845;border-radius:20px;color:var(--lime);white-space:nowrap}.session-list{display:grid;gap:10px}.session{display:flex;align-items:center;gap:12px;padding:12px;background:#17221b;border:1px solid #29382e;border-radius:13px}.datebox{width:47px;min-width:47px;background:#2a3d2d;border-radius:10px;text-align:center;padding:7px 4px}.datebox b{display:block;color:var(--lime);font-size:18px}.datebox small{font-size:8px;color:#c1d0c3;font-weight:800}.session-details{flex:1;min-width:0}.session-details strong{font-size:12px;display:block;margin-bottom:5px}.session-details small{font-size:10px;color:var(--muted)}.session-status{font-size:9px;color:var(--lime);white-space:nowrap}.review-link{display:inline-flex;align-items:center;justify-content:center;margin-top:7px;padding:7px 10px;border:1px solid #405845;border-radius:8px;color:var(--lime);text-decoration:none;font-size:10px;font-weight:800;white-space:nowrap}.review-link:hover{background:#243629}.empty{border:1px dashed #405044;border-radius:13px;padding:22px;text-align:center;color:var(--muted);font-size:11px}.split-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:9px}.split{border:1px solid var(--line);background:#17221b;border-radius:12px;padding:13px 9px;text-align:center;cursor:pointer;color:var(--text);transition:.18s}.split:hover,.split.selected{border-color:var(--lime);background:#243629}.split .emoji{font-size:21px;display:block;margin-bottom:8px}.split b{font-size:11px;display:block}.split small{font-size:9px;color:var(--muted);display:block;margin-top:5px}.split.selected b{color:var(--lime)}.modal-backdrop{position:fixed;inset:0;background:#000b;display:none;align-items:center;justify-content:center;padding:18px;z-index:10}.modal-backdrop.show{display:flex}.modal{width:min(530px,100%);background:#111a14;border:1px solid #405344;border-radius:20px;padding:24px;box-shadow:0 25px 80px #0009}.modal-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:7px}.modal h2{font-size:19px;margin:0}.close{background:transparent;border:0;color:var(--muted);font-size:23px;cursor:pointer}.modal p{font-size:11px;color:var(--muted);line-height:1.6;margin:8px 0 18px}.field{display:grid;gap:7px;margin-top:15px}.field label{font-size:10px;color:#b8c7bb;font-weight:750}.field input,.field select{width:100%;background:#1b2820;border:1px solid #3b4b3e;border-radius:10px;padding:12px;color:var(--text);outline:none}.field input:focus,.field select:focus{border-color:var(--lime)}.modal-actions{display:flex;justify-content:flex-end;gap:9px;margin-top:22px}

.inactive-state{text-align:center;padding:58px 25px;margin-top:10px}

.inactive-icon{width:66px;height:66px;display:grid;place-items:center;margin:0 auto 20px;background:#293622;color:var(--lime);border-radius:50%;font-size:27px;font-weight:900}

.inactive-state h2{font-size:22px;margin-bottom:12px}

.inactive-state p{max-width:470px;margin:0 auto 23px;color:var(--muted);font-size:13px;line-height:1.7}

.inactive-button{display:inline-flex;text-decoration:none}

.toast{position:fixed;bottom:22px;right:22px;background:#263b2b;color:var(--lime);border:1px solid #4b684d;padding:13px 17px;border-radius:12px;font-size:12px;display:none;z-index:20}.toast.show{display:block}.mobile-nav{display:none}

@media(max-width:1050px){.grid-stats{grid-template-columns:repeat(2,1fr)}.content-grid{grid-template-columns:1fr}}

@media(max-width:700px){.app{display:block}main{padding:20px 16px 90px}.topbar{margin-bottom:24px}.welcome{align-items:flex-start;flex-direction:column}.welcome h1{font-size:25px}.grid-stats{gap:9px}.stat{padding:13px}.stat strong{font-size:21px}.split-grid{grid-template-columns:repeat(2,1fr)}.membership h2{font-size:21px}}



.profile-grid{display:grid;gap:13px}

.profile-value{font-size:12px}



.transaction-list{display:grid;gap:10px}

.transaction{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:13px;background:#17221b;border:1px solid #29382e;border-radius:12px}

.transaction-main{min-width:0}.transaction-main strong{display:block;font-size:12px;margin-bottom:5px}

.transaction-main small{font-size:10px;color:var(--muted)}

.transaction-side{text-align:right;white-space:nowrap}.transaction-side strong{display:block;font-size:12px}

.status-chip{display:inline-block;margin-top:5px;padding:4px 7px;border-radius:20px;background:#29432e;color:var(--lime);font-size:9px;font-weight:800}

.status-chip.pending{background:#44391f;color:#ffd36a}.status-chip.cancelled{background:#482929;color:#ff9999}

.card-link{color:var(--lime);font-size:10px;text-decoration:none;font-weight:800}

.membership .progress span{width:{{ number_format($membershipProgress ?? 0, 1, '.', '') }}%}



</style>

</head>

<body>

<div class="app">

<main id="dashboard">

    <div class="topbar">

        <div class="breadcrumb">Member Area <span style="color:#536257">/</span> Dashboard</div>

        <div class="top-actions">

            <a href="{{ route('user.dashboard_user') }}" class="icon-btn" aria-label="Dashboard" style="display:grid;place-items:center;text-decoration:none">⌂</a>

            <div class="avatar">{{ strtoupper(substr($user->name ?? 'M', 0, 1)) }}</div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="logout-btn">Keluar ↗</button>
            </form>

        </div>

    </div>



    <section class="welcome">

        <div>

            <div class="eyebrow">MEMBER DASHBOARD</div>

            <h1>Halo, {{ $user->name }}! 👋</h1>

            <p>Progress dibangun dari konsistensi. Pantau membership, jadwal latihan, dan transaksi kamu di sini.</p>

        </div>

        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <a href="{{ url('/membership') }}" class="primary" style="text-decoration:none">＋ Beli / Perpanjang Membership</a>
            <a href="{{ route('member.pt-booking') }}" class="secondary" style="display:inline-flex;align-items:center;text-decoration:none">＋ Booking Personal Trainer</a>
        </div>

    </section>



    @if(session('success'))

        <div class="card" style="border-color:#4b684d;color:var(--lime);font-size:12px">{{ session('success') }}</div>

    @endif



    @if($errors->any())

        <div class="card" style="border-color:#854747;color:#ffaaaa;font-size:12px">

            @foreach($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif



    @if($membershipActive)

        <section class="grid-stats">

            <div class="stat">

                <div class="stat-head"><span>Sisa Membership</span><span class="stat-icon">◷</span></div>

                <strong>{{ $membershipDaysLeft }} Hari</strong>

            </div>

            <div class="stat">

                <div class="stat-head"><span>Total Sesi PT</span><span class="stat-icon">🏋</span></div>

                <strong>{{ $totalSessions }}</strong>

                <small>Total sesi yang dibeli</small>

            </div>

            <div class="stat">

                <div class="stat-head"><span>Sesi Selesai</span><span class="stat-icon">✓</span></div>

                <strong>{{ $completedSessions }}</strong>

                <small>Latihan yang sudah selesai</small>

            </div>

            <div class="stat">

                <div class="stat-head"><span>Sisa Sesi PT</span><span class="stat-icon">＋</span></div>

                <strong>{{ $remainingSessions }}</strong>

                <small>Sesi belum diselesaikan</small>

            </div>

        </section>



        <section class="card membership">

            <div class="membership-top">

                <span class="eyebrow">MEMBERSHIP KAMU</span>

                <span class="pill">● ACTIVE</span>

            </div>

            <h2>GYMBRO — Membership Aktif</h2>

            <p>Keanggotaan aktif</p>

            <div class="progress"><span style="width:{{ max(0, min(100, (float) ($membershipProgress ?? 0))) }}%"></span></div>

            <div class="membership-foot">

                <span>Mulai {{ $user->membership_start ? \Carbon\Carbon::parse($user->membership_start)->translatedFormat('d F Y') : '-' }}</span>

                <span>Sisa {{ $membershipDaysLeft }} hari · Berakhir {{ $user->membership_end ? \Carbon\Carbon::parse($user->membership_end)->translatedFormat('d F Y') : '-' }}</span>

            </div>

        </section>

        @php
            $upcomingSchedules = $schedules->filter(function ($schedule) {
                $scheduleDateTime = \Carbon\Carbon::parse($schedule->tanggal . ' ' . $schedule->jam);
                return $scheduleDateTime->gte(now())
                    && in_array($schedule->status, ['scheduled', 'pending', 'approved']);
            })->sortBy(function ($schedule) {
                return \Carbon\Carbon::parse($schedule->tanggal . ' ' . $schedule->jam)->timestamp;
            });

            $nextSchedule = $upcomingSchedules->first();
        @endphp

        <section class="card next-session">
            <div class="card-title">
                <div>
                    <h2>Jadwal Latihan Berikutnya</h2>
                    <div class="subtle" style="margin-top:5px">Sesi terdekat yang sudah kamu pesan</div>
                </div>
                <span class="pill">UPCOMING</span>
            </div>

            @if($nextSchedule)
                @php
                    $nextDate = \Carbon\Carbon::parse($nextSchedule->tanggal);
                    $nextStatus = [
                        'scheduled' => 'Terjadwal',
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                    ][$nextSchedule->status] ?? ucfirst($nextSchedule->status);
                @endphp

                <div class="next-session-content">
                    <div class="next-session-date">
                        <b>{{ $nextDate->format('d') }}</b>
                        <small>{{ strtoupper($nextDate->translatedFormat('M Y')) }}</small>
                    </div>
                    <div class="next-session-info">
                        <strong>{{ $nextSchedule->pt_name ?: 'Sesi Personal Training' }}</strong>
                        <small>{{ substr($nextSchedule->jam, 0, 5) }} WIB · Personal Training</small>
                    </div>
                    <span class="next-session-status">{{ $nextStatus }}</span>
                </div>
            @else
                <div class="empty">Belum ada jadwal latihan mendatang. Kamu bisa memesan sesi PT kapan saja.</div>
            @endif
        </section>




        <div class="content-grid">

            <div>

                <section class="card" id="jadwal">

                    <div class="card-title">

                        <div>

                            <h2>Jadwal Latihan</h2>

                            <div class="subtle" style="margin-top:5px">Jadwal sesi PT yang sudah kamu pesan</div>

                        </div>

                        <a href="{{ route('member.pt-booking') }}" class="card-link">＋ Booking sesi PT</a>

                    </div>

                    @if($upcomingSchedules->isNotEmpty())

                        <div class="session-list">

                            @foreach($upcomingSchedules as $schedule)

                                @php

                                    $scheduleDate = \Carbon\Carbon::parse($schedule->tanggal);

                                    $statusLabel = [

                                        'scheduled' => 'Terjadwal',

                                        'pending' => 'Menunggu',

                                        'approved' => 'Disetujui',

                                    ][$schedule->status] ?? ucfirst($schedule->status);

                                @endphp

                                <div class="session">

                                    <div class="datebox">

                                        <b>{{ $scheduleDate->format('d') }}</b>

                                        <small>{{ strtoupper($scheduleDate->translatedFormat('M')) }}</small>

                                    </div>

                                    <div class="session-details">

                                        <strong>{{ $schedule->pt_name ?: "Sesi Personal Training" }}</strong>

                                        <small>{{ substr($schedule->jam, 0, 5) }} WIB · {{ $schedule->pt_name ?? 'Latihan mandiri' }}</small>

                                    </div>

                                    <span class="session-status">{{ $statusLabel }}</span>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty">Belum ada jadwal latihan mendatang. Kamu bisa memilih sesi PT melalui tombol Booking Personal Trainer.</div>

                    @endif

                </section>



                



                

            </div>



            <div>



                <section class="card" id="profil">

                    <div class="card-title">

                        <h2>Informasi Member</h2>
                        <div style="display:flex;gap:8px;flex-wrap:wrap"><button type="button" class="secondary" id="openProfileModal">Edit Profil</button><button type="button" class="secondary" id="openPasswordModal">Ganti Password</button></div>

                    </div>

                    <div class="profile-grid">

                        <div><div class="subtle">Nama Lengkap</div><strong class="profile-value">{{ $user->name }}</strong></div>

                        <div><div class="subtle">Email</div><strong class="profile-value">{{ $user->email }}</strong></div>

                        <div><div class="subtle">Nomor HP</div><strong class="profile-value">{{ $user->phone ?? '-' }}</strong></div>

                    </div>

                </section>

            </div>

        </div>

    

        <section class="card" id="transaksi">

                    <div class="card-title">

                        <div>

                            <h2>Riwayat Transaksi</h2>

                            <div class="subtle" style="margin-top:5px">10 transaksi terbaru kamu</div>

                        </div>

                    </div>

                    @if($transactions->isNotEmpty())

                        <div class="transaction-list">

                            @foreach($transactions as $transaction)

                                @php

                                    $isMembership = $transaction->jenis_transaksi === 'membership';

                                    $transactionTitle = $isMembership

                                        ? 'Membership ' . ($transaction->membership_months ?? '') . ' Bulan'

                                        : 'Sesi Personal Trainer';

                                    $transactionDate = $transaction->tanggal_transaksi ?? $transaction->created_at;

                                    $transactionStatus = strtolower($transaction->status ?? 'pending');

                                @endphp

                                <div class="transaction">

                                    <div class="transaction-main">

                                        <strong>{{ $transactionTitle }}</strong>

                                        <small>

                                            {{ $transactionDate ? \Carbon\Carbon::parse($transactionDate)->translatedFormat('d F Y, H:i') : '-' }}

                                            @if(!$isMembership && $transaction->pt_name)

                                                · {{ $transaction->pt_name }}

                                            @elseif(!$isMembership)

                                                · {{ $transaction->jumlah_sesi ?? 0 }} sesi

                                            @endif

                                        </small>

                                    </div>

                                    <div class="transaction-side">

                                        <strong>Rp{{ number_format((float) $transaction->total_harga, 0, ',', '.') }}</strong>

                                        <span class="status-chip {{ in_array($transactionStatus, ['pending']) ? 'pending' : (in_array($transactionStatus, ['rejected', 'cancelled']) ? 'cancelled' : '') }}">

                                            {{ ucfirst($transactionStatus) }}

                                        </span>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty">Belum ada transaksi yang tercatat.</div>

                    @endif

                </section>

        <section class="card" id="aktivitas-terakhir">

                    <div class="card-title"><h2>Aktivitas Latihan Terakhir</h2></div>

                    @if($recentActivities->isNotEmpty())

                        <div class="session-list">

                            @foreach($recentActivities as $activity)

                                @php $activityDate = \Carbon\Carbon::parse($activity->tanggal); @endphp

                                <div class="session">

                                    <div class="datebox"><b>{{ $activityDate->format('d') }}</b><small>{{ strtoupper($activityDate->translatedFormat('M')) }}</small></div>

                                    <div class="session-details">

                                        <strong>{{ $activity->pt_name ?: "Sesi Personal Training" }}</strong>

                                        <small>Selesai {{ substr($activity->jam, 0, 5) }} WIB · {{ $activity->pt_name ?? 'Latihan mandiri' }}</small>

                                    </div>

                                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px">
                                        <span class="session-status">✓ Selesai</span>
                                        @if($activity->pt_id && !in_array((int) $activity->pt_id, $reviewedPtIds ?? [], true))
                                            <a class="review-link" href="{{ route('member.pt-review.create', $activity->pt_id) }}">Beri Ulasan</a>
                                        @elseif($activity->pt_id)
                                            <span class="subtle" style="font-size:9px;color:var(--lime)">Sudah diulas</span>
                                        @endif
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty">Belum ada aktivitas latihan yang selesai.</div>

                    @endif

                </section>

    @else

        <section class="card inactive-state" id="inactiveMembership">

            <div class="inactive-icon">!</div>

            <h2>Membership Belum Aktif</h2>

            <p>

                Membership kamu belum aktif atau sudah berakhir.

                Silakan aktifkan membership terlebih dahulu untuk

                mengakses dashboard dan fasilitas member GYMBRO.

            </p>

            <a href="{{ url('/membership') }}" class="primary inactive-button">Aktifkan Membership</a>

        </section>



        <section class="card" id="profil">

            <div class="card-title">
                <h2>Informasi Member</h2>
                <div style="display:flex;gap:8px;flex-wrap:wrap"><button type="button" class="secondary" id="openProfileModal">Edit Profil</button><button type="button" class="secondary" id="openPasswordModal">Ganti Password</button></div>
            </div>

            <div class="profile-grid">

                <div><div class="subtle">Nama Lengkap</div><strong class="profile-value">{{ $user->name }}</strong></div>

                <div><div class="subtle">Email</div><strong class="profile-value">{{ $user->email }}</strong></div>

                <div><div class="subtle">Nomor HP</div><strong class="profile-value">{{ $user->phone ?? '-' }}</strong></div>

            </div>

        </section>

    @endif

</main>

</div>


<!-- MODAL EDIT INFORMASI MEMBER -->
<div class="modal-backdrop" id="profileModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="profileModalTitle">
        <div class="modal-head">
            <h2 id="profileModalTitle">Edit Informasi Member</h2>
            <button type="button" class="close" id="closeProfileModal" aria-label="Tutup">×</button>
        </div>
        <p>Perbarui informasi akun member GYMBRO kamu.</p>

        <form method="POST" action="{{ route('member.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="profile_name">Nama Lengkap</label>
                <input
                    type="text"
                    id="profile_name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    maxlength="255"
                    autocomplete="name"
                    required
                >
                @error('name')
                    <small style="color:#ff9999">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="profile_email">Email</label>
                <input
                    type="email"
                    id="profile_email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    maxlength="255"
                    autocomplete="email"
                    required
                >
                @error('email')
                    <small style="color:#ff9999">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="profile_phone">Nomor HP</label>
                <input
                    type="tel"
                    id="profile_phone"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    maxlength="20"
                    autocomplete="tel"
                    placeholder="Contoh: 081234567890"
                >
                @error('phone')
                    <small style="color:#ff9999">{{ $message }}</small>
                @enderror
            </div>

            <div class="modal-actions">
                <button type="button" class="secondary" id="cancelProfileEdit">Batal</button>
                <button type="submit" class="primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL GANTI PASSWORD -->
<div class="modal-backdrop" id="passwordModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="passwordModalTitle">
        <div class="modal-head">
            <h2 id="passwordModalTitle">Ganti Password</h2>
            <button type="button" class="close" id="closePasswordModal" aria-label="Tutup">×</button>
        </div>
        <p>Masukkan password lama, lalu tentukan password baru untuk akun GYMBRO kamu.</p>
        <form method="POST" action="{{ route('member.password.update') }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" autocomplete="current-password" required>
                @error('current_password') <small style="color:#ff9999">{{ $message }}</small> @enderror
            </div>
            <div class="field">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" minlength="8" autocomplete="new-password" required>
                @error('password') <small style="color:#ff9999">{{ $message }}</small> @enderror
            </div>
            <div class="field">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" autocomplete="new-password" required>
            </div>
            <div class="modal-actions">
                <button type="button" class="secondary" id="cancelPasswordEdit">Batal</button>
                <button type="submit" class="primary">Simpan Password</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('profileModal');
    const openButton = document.getElementById('openProfileModal');
    const closeButton = document.getElementById('closeProfileModal');
    const cancelButton = document.getElementById('cancelProfileEdit');

    if (!modal) return;

    const openModal = () => {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.getElementById('profile_name')?.focus();
    };

    const closeModal = () => {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    };

    openButton?.addEventListener('click', openModal);
    closeButton?.addEventListener('click', closeModal);
    cancelButton?.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });

    // Buka kembali modal jika validasi profil gagal agar pesan error terlihat.
    @if($errors->hasAny(['name', 'email', 'phone']))
        openModal();
    @endif

    const passwordModal = document.getElementById('passwordModal');
    const openPasswordButton = document.getElementById('openPasswordModal');
    const closePasswordButton = document.getElementById('closePasswordModal');
    const cancelPasswordButton = document.getElementById('cancelPasswordEdit');

    const openPasswordModal = () => {
        passwordModal?.classList.add('show');
        passwordModal?.setAttribute('aria-hidden', 'false');
        document.getElementById('current_password')?.focus();
    };
    const closePasswordModal = () => {
        passwordModal?.classList.remove('show');
        passwordModal?.setAttribute('aria-hidden', 'true');
    };

    openPasswordButton?.addEventListener('click', openPasswordModal);
    closePasswordButton?.addEventListener('click', closePasswordModal);
    cancelPasswordButton?.addEventListener('click', closePasswordModal);
    passwordModal?.addEventListener('click', function (event) {
        if (event.target === passwordModal) closePasswordModal();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && passwordModal?.classList.contains('show')) {
            closePasswordModal();
        }
    });

    @if($errors->hasAny(['current_password', 'password']))
        openPasswordModal();
    @endif
});
</script>

</body>

</html>
