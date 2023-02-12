import { ChangeEvent, Dispatch, FC, SetStateAction, useState, SyntheticEvent } from 'react';
import { IAuthor, IBook, IEditable } from './Books';

interface IEditableSelectProps {
    editable: any;
    setEditable: Dispatch<SetStateAction<IEditable>>;
    setData: Dispatch<SetStateAction<IBook[]>>;
    name: string;
    id: number;
    value: IAuthor[];
    options: IAuthor[];
}

const EditableMultiSelect: FC<IEditableSelectProps> = ({
    editable,
    setEditable,
    setData,
    id,
    name,
    value: initialValue,
    options,
}) => {
    const [value, setValue] = useState<string[]>(initialValue.map((author) => `${author.id}`));
    const [error, setError] = useState<string>('');

    const handlerChange = (e: ChangeEvent<HTMLSelectElement>) => {
        const selectedOptions = Array.from(e.target.selectedOptions);
        setValue(selectedOptions.map((el) => el.value));
    };

    const handlerBlur = async (e: SyntheticEvent) => {
        e.stopPropagation();

        const initArr = initialValue.map((author) => `${author.id}`);
        const isEqual = initArr.length === value.length && initArr.every((item) => value.includes(item));
        if (isEqual) {
            setEditable({
                name: null,
                id: null,
                isActive: false,
            });
            setError(null);
            return;
        }

        try {
            const requestOptions = {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ [name]: value }),
            };
            const response = await fetch(`/api/books/${id}`, requestOptions);
            const data = await response.json();

            if (response.status === 200) {
                setData((old) => old.map((row) => (row.id === id ? data?.data : row)));
                setEditable({
                    name: null,
                    id: null,
                    isActive: false,
                });
                setError(null);
            } else if (response.status === 422) {
                setError(data?.errors[name].join('. '));
            }
        } catch (e) {
            setError(e);
        }
    };

    const handlerSubmit = (e: SyntheticEvent) => {
        e.preventDefault();
        handlerBlur(e);
    };

    const handlerClick = () => {
        setEditable({
            name: name,
            id: id,
            isActive: true,
        });
        setValue(initialValue.map((author) => `${author.id}`));
        setError(null);
    };

    const Form = () => {
        return (
            <form onSubmit={handlerSubmit}>
                <select
                    value={value}
                    onChange={handlerChange}
                    onBlur={handlerBlur}
                    autoFocus
                    multiple={true}
                    className={`form-control form-control-sm ${error && 'is-invalid'}`}
                    style={{ maxWidth: '200px' }}
                >
                    <option value=""></option>
                    {options.map((option) => (
                        <option value={option.id}>{option.fullName}</option>
                    ))}
                </select>

                {error && (
                    <span className="invalid-feedback d-block">
                        <span className="form-error-message">{error}</span>
                    </span>
                )}
            </form>
        );
    };

    return (
        <div onClick={handlerClick} style={{ minHeight: '24px' }}>
            {editable.isActive && editable.id === id && editable.name === name ? (
                <Form />
            ) : (
                initialValue.map((author, index) => (
                    <span key={author.id}>
                        {index !== 0 && ', '}
                        <span>{author.fullName}</span>
                    </span>
                ))
            )}
        </div>
    );
};

export default EditableMultiSelect;
