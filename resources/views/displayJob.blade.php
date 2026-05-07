<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Careers — Open Positions</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:       #0d0d12;
            --ink2:      #1c1c28;
            --ink3:      #2a2a3a;
            --paper:     #f7f5f0;
            --paper2:    #efece5;
            --line:      rgba(13,13,18,0.1);
            --gold:      #c9a84c;
            --gold2:     #e8c97a;
            --open-bg:   #e8f5ee;
            --open-fg:   #1a6b3c;
            --closed-bg: #fce8e8;
            --closed-fg: #9b2020;
            --shadow:    0 4px 32px rgba(13,13,18,0.1);
            --shadow-lg: 0 16px 64px rgba(13,13,18,0.15);
        }

        body {
            background: var(--paper);
            color: var(--ink);
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── Grain overlay ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ─── Layout ─── */
        .wrapper {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 32px 100px;
        }

        /* ─── Hero header ─── */
        .hero {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: end;
            gap: 32px;
            padding: 72px 0 56px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 56px;
            animation: riseIn 0.7s ease both;
        }

        .hero-eyebrow {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 16px;
        }

        .hero-eyebrow::after {
            content: '';
            flex: 1;
            max-width: 48px;
            height: 1px;
            background: var(--gold);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 6vw, 5.5rem);
            font-weight: 900;
            line-height: 0.95;
            letter-spacing: -0.03em;
            color: var(--ink);
        }

        .hero h1 em {
            font-style: italic;
            color: var(--gold);
        }

        .hero-sub {
            margin-top: 20px;
            font-size: 1rem;
            font-weight: 300;
            color: rgba(13,13,18,0.5);
            max-width: 420px;
            line-height: 1.7;
        }

        /* ─── Stats ─── */
        .stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .stat-item {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(13,13,18,0.4);
        }

        .stat-divider {
            width: 32px;
            height: 1px;
            background: var(--line);
            align-self: flex-end;
            margin: 4px 0;
        }

        /* ─── Filter row ─── */
        .filter-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            animation: riseIn 0.7s 0.1s ease both;
        }

        .filter-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(13,13,18,0.4);
        }

        .filter-pills {
            display: flex;
            gap: 8px;
        }

        .pill {
            padding: 7px 18px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 500;
            border: 1px solid var(--line);
            background: transparent;
            color: rgba(13,13,18,0.5);
            cursor: pointer;
            transition: all 0.2s;
        }

        .pill:hover { background: var(--ink); color: var(--paper); border-color: var(--ink); }
        .pill.active { background: var(--ink); color: var(--paper); border-color: var(--ink); }

        /* ─── Job list ─── */
        .jobs-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* ─── Job card — editorial row style ─── */
        .job-card {
            background: transparent;
            border-top: 1px solid var(--line);
            padding: 36px 0;
            display: grid;
            grid-template-columns: 56px 1fr auto;
            gap: 0 32px;
            align-items: start;
            cursor: default;
            transition: background 0.25s ease;
            animation: riseIn 0.5s ease both;
            position: relative;
        }

        .job-card:last-child { border-bottom: 1px solid var(--line); }

        .job-card:hover { background: rgba(201,168,76,0.04); }
        .job-card:hover .card-num { color: var(--gold); }
        .job-card:hover .apply-btn { opacity: 1; transform: translateX(0); }

        .card-num {
            font-family: 'Playfair Display', serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: rgba(13,13,18,0.2);
            padding-top: 4px;
            transition: color 0.25s;
        }

        /* ─── Card body ─── */
        .card-body { }

        .card-top-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .job-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .status-badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .status-open  { background: var(--open-bg);   color: var(--open-fg); }
        .status-open::before  { background: var(--open-fg);  animation: pulse 2s infinite; }
        .status-closed { background: var(--closed-bg); color: var(--closed-fg); }
        .status-closed::before { background: var(--closed-fg); }

        /* Meta chips */
        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--paper2);
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 5px 11px;
            font-size: 0.76rem;
            color: rgba(13,13,18,0.55);
        }

        .meta-chip strong { color: var(--ink); font-weight: 500; }

        /* Content grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 640px) {
            .content-grid { grid-template-columns: 1fr; }
        }

        .section-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: rgba(13,13,18,0.35);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::before {
            content: '';
            width: 16px;
            height: 1px;
            background: var(--gold);
        }

        .section-text {
            font-size: 0.85rem;
            line-height: 1.75;
            color: rgba(13,13,18,0.6);
            font-weight: 300;
        }

        /* ─── Apply button (right column) ─── */
        .card-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            padding-top: 6px;
        }

        .apply-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--ink);
            color: var(--paper);
            border: none;
            border-radius: 100px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(8px);
            transition: opacity 0.25s ease, transform 0.25s ease, background 0.2s ease;
        }

        .apply-btn:hover { background: var(--gold); color: var(--ink); }
        .apply-btn svg { width: 14px; height: 14px; transition: transform 0.2s; }
        .apply-btn:hover svg { transform: translateX(3px); }

        .apply-btn.disabled {
            background: rgba(13,13,18,0.15);
            color: rgba(13,13,18,0.35);
            cursor: not-allowed;
        }

        .apply-btn.disabled:hover { background: rgba(13,13,18,0.15); color: rgba(13,13,18,0.35); }
        .apply-btn.disabled svg { display: none; }

        /* ─── Empty ─── */
        .empty {
            text-align: center;
            padding: 100px 20px;
            color: rgba(13,13,18,0.3);
        }

        .empty-icon { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }

        /* ─── MODAL ─── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13,13,18,0.55);
            backdrop-filter: blur(6px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 24px;
            animation: fadeOverlay 0.25s ease;
        }

        .modal-overlay.active { display: flex; }

        .modal {
            background: var(--paper);
            border-radius: 20px;
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        .modal-header {
            padding: 36px 36px 0;
            border-bottom: 1px solid var(--line);
            padding-bottom: 24px;
            margin-bottom: 32px;
        }

        .modal-eyebrow {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 8px;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--line);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: rgba(13,13,18,0.4);
            transition: background 0.2s, color 0.2s;
        }

        .modal-close:hover { background: var(--ink); color: var(--paper); }

        .modal-body { padding: 0 36px 36px; }

        /* Form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-field.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(13,13,18,0.45);
        }

        .form-label span { color: var(--gold); margin-left: 2px; }

        .form-input,
        .form-textarea,
        .form-select {
            background: var(--paper2);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 12px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.88rem;
            color: var(--ink);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }

        .form-textarea { resize: vertical; min-height: 100px; }

        /* File upload */
        .file-upload {
            border: 2px dashed var(--line);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            position: relative;
        }

        .file-upload:hover { border-color: var(--gold); background: rgba(201,168,76,0.04); }
        .file-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

        .file-upload-icon { font-size: 1.8rem; margin-bottom: 8px; }
        .file-upload-text { font-size: 0.82rem; color: rgba(13,13,18,0.5); }
        .file-upload-text strong { color: var(--ink); }

        .file-name {
            font-size: 0.78rem;
            color: var(--gold);
            margin-top: 6px;
            font-weight: 500;
        }

        /* Submit row */
        .submit-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--line);
        }

        .submit-note {
            font-size: 0.75rem;
            color: rgba(13,13,18,0.35);
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            background: var(--ink);
            color: var(--paper);
            border: none;
            border-radius: 100px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .submit-btn:hover { background: var(--gold); color: var(--ink); }
        .submit-btn:active { transform: scale(0.97); }

        /* Success state */
        .success-state {
            text-align: center;
            padding: 48px 32px;
            display: none;
        }

        .success-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--open-bg);
            color: var(--open-fg);
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .success-sub {
            font-size: 0.88rem;
            color: rgba(13,13,18,0.5);
            line-height: 1.7;
        }

        /* ─── Animations ─── */
        @keyframes riseIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeOverlay {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.35; }
        }

        /* ─── Card stagger ─── */
        .job-card:nth-child(1) { animation-delay: 0.12s; }
        .job-card:nth-child(2) { animation-delay: 0.20s; }
        .job-card:nth-child(3) { animation-delay: 0.28s; }
        .job-card:nth-child(4) { animation-delay: 0.36s; }
        .job-card:nth-child(5) { animation-delay: 0.44s; }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .hero {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .stats { flex-direction: row; align-items: baseline; flex-wrap: wrap; }
            .job-card {
                grid-template-columns: 40px 1fr;
                grid-template-rows: auto auto;
            }
            .card-actions {
                grid-column: 2;
                align-items: flex-start;
            }
            .apply-btn { opacity: 1; transform: none; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

    <div class="wrapper">

        {{-- ── Hero ── --}}
        <div class="hero">
            <div>
                <div class="hero-eyebrow">We're hiring</div>
                <h1>Join Our<br><em>Team</em></h1>
                <p class="hero-sub">Discover open positions where your talent meets purpose. Every role is a chance to build something meaningful.</p>
            </div>

            @php
                $totalJobs  = $jobs->count();
                $openJobs   = $jobs->filter(fn($j) => \Carbon\Carbon::parse($j->enddate)->gte(\Carbon\Carbon::today()))->count();
                $closedJobs = $totalJobs - $openJobs;
                $totalPosts = $jobs->sum('post');
            @endphp

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-num">{{ $totalJobs }}</div>
                    <div class="stat-label">Total Roles</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-num">{{ $openJobs }}</div>
                    <div class="stat-label">Open Now</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num">{{ $totalPosts }}</div>
                    <div class="stat-label">Positions</div>
                </div>
            </div>
        </div>

        {{-- ── Filter row ── --}}
        <div class="filter-row">
            <div class="filter-label">{{ $totalJobs }} position{{ $totalJobs !== 1 ? 's' : '' }} found</div>
            <div class="filter-pills">
                <button class="pill active" onclick="filterJobs('all', this)">All</button>
                <button class="pill" onclick="filterJobs('open', this)">Open</button>
                <button class="pill" onclick="filterJobs('closed', this)">Closed</button>
            </div>
        </div>

        {{-- ── Job list ── --}}
        @if ($jobs->isEmpty())
            <div class="empty">
                <div class="empty-icon">📭</div>
                <p>No job postings found at the moment.</p>
            </div>
        @else
            <div class="jobs-list" id="jobsList">
                @foreach ($jobs as $index => $job)
                    @php
                        $isOpen = \Carbon\Carbon::parse($job->enddate)->gte(\Carbon\Carbon::today());
                    @endphp

                    <div class="job-card" data-status="{{ $isOpen ? 'open' : 'closed' }}">

                        {{-- Index number --}}
                        <div class="card-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

                        {{-- Main body --}}
                        <div class="card-body">
                            <div class="card-top-row">
                                <div class="job-title">{{ $job->title }}</div>
                                @if ($isOpen)
                                    <div class="status-badge status-open">Open</div>
                                @else
                                    <div class="status-badge status-closed">Closed</div>
                                @endif
                            </div>

                            <div class="meta-row">
                                <div class="meta-chip">
                                    📅 &nbsp;Start &nbsp;<strong>{{ \Carbon\Carbon::parse($job->startdate)->format('d M Y') }}</strong>
                                </div>
                                <div class="meta-chip">
                                    ⏳ &nbsp;Deadline &nbsp;<strong>{{ \Carbon\Carbon::parse($job->enddate)->format('d M Y') }}</strong>
                                </div>
                                <div class="meta-chip">
                                    🧑‍💼 &nbsp;Positions &nbsp;<strong>{{ $job->post }}</strong>
                                </div>
                            </div>

                            <div class="content-grid">
                                <div>
                                    <div class="section-label">Requirements</div>
                                    <p class="section-text">{{ $job->jr }}</p>
                                </div>
                                <div>
                                    <div class="section-label">Description</div>
                                    <p class="section-text">{{ $job->jd }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Apply button column --}}
                        <div class="card-actions">
                            @if ($isOpen)
                                <button
                                    class="apply-btn"
                                    onclick="openModal('{{ addslashes($job->title) }}', '{{ $job->id }}')"
                                >
                                    Apply Now
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            @else
                                <button class="apply-btn disabled" disabled>Closed</button>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ── Apply Modal ── --}}
    <div class="modal-overlay" id="applyModal" onclick="closeModalOnOverlay(event)">
        <div class="modal" role="dialog" aria-modal="true">
            <button class="modal-close" onclick="closeModal()" aria-label="Close">✕</button>

            {{-- Form view --}}
            <div id="formView">
                <div class="modal-header">
                    <div class="modal-eyebrow">Application Form</div>
                    <div class="modal-title" id="modalJobTitle">Job Title</div>
                </div>

                <div class="modal-body">
                    <form id="applyForm" onsubmit="handleSubmit(event)">
                        <input type="hidden" name="job_id" id="modalJobId">

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="firstName">First Name <span>*</span></label>
                                <input class="form-input" type="text" id="firstName" name="first_name" placeholder="Jane" required>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="lastName">Last Name <span>*</span></label>
                                <input class="form-input" type="text" id="lastName" name="last_name" placeholder="Smith" required>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="email">Email <span>*</span></label>
                                <input class="form-input" type="email" id="email" name="email" placeholder="jane@example.com" required>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input class="form-input" type="tel" id="phone" name="phone" placeholder="+1 (555) 000-0000">
                            </div>
                            <div class="form-field full">
                                <label class="form-label" for="address">Current Address</label>
                                <input class="form-input" type="text" id="address" name="address" placeholder="City, Country">
                            </div>
                            <div class="form-field full">
                                <label class="form-label" for="coverLetter">Cover Letter <span>*</span></label>
                                <textarea class="form-textarea" id="coverLetter" name="cover_letter" placeholder="Tell us why you're a great fit for this role…" required></textarea>
                            </div>
                            <div class="form-field full">
                                <label class="form-label">Resume / CV <span>*</span></label>
                                <div class="file-upload" onclick="document.getElementById('resumeFile').click()">
                                    <input type="file" id="resumeFile" name="resume" accept=".pdf,.doc,.docx" onchange="updateFileName(this)" required>
                                    <div class="file-upload-icon">📄</div>
                                    <div class="file-upload-text"><strong>Click to upload</strong> your resume</div>
                                    <div class="file-upload-text">PDF, DOC, DOCX — max 5 MB</div>
                                    <div class="file-name" id="fileName"></div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-row">
                            <span class="submit-note">Fields marked <span style="color:var(--gold)">*</span> are required</span>
                            <button type="submit" class="submit-btn">
                                Submit Application
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Success view --}}
            <div class="success-state" id="successView">
                <div class="success-icon">✓</div>
                <div class="success-title">Application Sent!</div>
                <p class="success-sub">
                    Thank you for applying to <strong id="successJobName"></strong>.<br>
                    We'll review your application and get back to you soon.
                </p>
                <button class="submit-btn" style="margin-top:28px" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // ── Filter ──
        function filterJobs(status, btn) {
            document.querySelectorAll('.pill').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.job-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // ── Modal ──
        function openModal(title, jobId) {
            document.getElementById('modalJobTitle').textContent = title;
            document.getElementById('modalJobId').value = jobId;
            document.getElementById('formView').style.display = '';
            document.getElementById('successView').style.display = 'none';
            document.getElementById('applyForm').reset();
            document.getElementById('fileName').textContent = '';
            document.getElementById('applyModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('applyModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeModalOnOverlay(e) {
            if (e.target === document.getElementById('applyModal')) closeModal();
        }

        // ── File name display ──
        function updateFileName(input) {
            const label = document.getElementById('fileName');
            label.textContent = input.files.length ? '📎 ' + input.files[0].name : '';
        }

        // ── Form submit ──
        function handleSubmit(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const jobTitle = document.getElementById('modalJobTitle').textContent;
            const btn      = e.target.querySelector('.submit-btn');

            btn.disabled    = true;
            btn.textContent = 'Submitting…';

            fetch('{{ route("jobs.apply") }}', {
                method:  'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept':       'application/json',
                },
                body: formData,
            })
            .then(async res => {
                const data = await res.json();
                if (res.ok && data.success) {
                    showSuccess(jobTitle);
                } else {
                    const msg = data.message
                        || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Something went wrong.');
                    alert(msg);
                    btn.disabled    = false;
                    btn.textContent = 'Submit Application';
                }
            })
            .catch(() => {
                alert('Network error. Please try again.');
                btn.disabled    = false;
                btn.textContent = 'Submit Application';
            });
        }

        function showSuccess(title) {
            document.getElementById('successJobName').textContent = title;
            document.getElementById('formView').style.display = 'none';
            document.getElementById('successView').style.display = 'block';
        }

        // ── Escape key ──
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
    </script>

</body>
</html>