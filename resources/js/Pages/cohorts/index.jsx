import React from 'react';
import { Link } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head } from '@inertiajs/react';

export default function Index({ cohorts }) {
    return (
        <GuestLayout>
            <Head title="Cohorts" />

            <div className="flex justify-between items-center mb-4">
                <h1 className="text-2xl font-bold">Cohorts</h1>
                <Link
                    href={route('cohorts.create')}
                    className="px-4 py-2 bg-blue-500 text-white rounded"
                >
                    Create Cohort
                </Link>
            </div>

            <div className="overflow-x-auto">
                <table className="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th className="py-2 px-4 border-b border-gray-200">ID</th>
                            <th className="py-2 px-4 border-b border-gray-200">Number</th>
                            <th className="py-2 px-4 border-b border-gray-200">Name</th>
                            <th className="py-2 px-4 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {cohorts.map((cohort) => (
                            <tr key={cohort.id}>
                                <td className="py-2 px-4 border-b border-gray-200">{cohort.id}</td>
                                <td className="py-2 px-4 border-b border-gray-200">{cohort.number}</td>
                                <td className="py-2 px-4 border-b border-gray-200">{cohort.name}</td>
                                <td className="py-2 px-4 border-b border-gray-200">
                                    <Link
                                        href={route('cohorts.edit', cohort.id)}
                                        className="text-blue-500 hover:underline mr-2"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        href={route('cohorts.show', cohort.id)}
                                        className="text-blue-500 hover:underline"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </GuestLayout>
    );
}
